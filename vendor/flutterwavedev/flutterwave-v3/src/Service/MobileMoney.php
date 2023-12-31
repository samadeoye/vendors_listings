<?php

declare(strict_types=1);

namespace Flutterwave\Service;

use Flutterwave\Contract\ConfigInterface;
use Flutterwave\Contract\Payment;
use Flutterwave\EventHandlers\MomoEventHandler;
use Flutterwave\Entities\Payload;
use Flutterwave\Traits\Group\Charge;
use Flutterwave\Util\Currency;
use Psr\Http\Client\ClientExceptionInterface;

class MobileMoney extends Service implements Payment
{
    use Charge;

    protected ?string $type = null;
    protected array $types = [
        Currency::RWF => 'mobile_money_rwanda',
        Currency::GHS => 'mobile_money_ghana',
        Currency::UGX => 'mobile_money_uganda',
        Currency::XAF => 'mobile_money_franco',
        Currency::ZMW => 'mobile_money_zambia',
        Currency::TZS => 'mobile_money_tanzania'
    ];

    private array $networks = [
        'GH' => ['MTN','VODOFONE','TIGO'],
        'UG' => ['MTN', 'AIRTEL'],
        'ZM' => ['MTN', 'ZAMTEL'],
        'Tz' => ['AIRTEL', 'TIGO', 'HALOPESA', 'VODOFONE' ]
    ];

    private array $supported_countries_franco = [
        'CM', 'SN', 'BF', 'CI',
    ];
    private ?MomoEventHandler $eventHandler = null;

    public function __construct(?ConfigInterface $config = null)
    {
        parent::__construct($config);
        $endpoint = $this->getEndpoint();
        $this->url = $this->baseUrl . '/' . $endpoint . '?type=';
        $this->eventHandler = new MomoEventHandler($config);
    }

    /**
     * @param  Payload $payload
     * @return array
     * @throws ClientExceptionInterface
     */
    public function initiate(Payload $payload): array
    {
        return $this->charge($payload);
    }

    /**
     * @param  Payload $payload
     * @return array
     * @throws ClientExceptionInterface
     */
    public function charge(Payload $payload): array
    {
        $currency = $payload->get('currency');
        $otherData = $payload->get('otherData');

        if (! array_key_exists($currency, $this->types)) {
            $supported_currencies = json_encode(array_keys($this->types));
            $msg = "The currency {$currency} is not supported for this payment method. 
            options [ {$supported_currencies} ]";
            $this->logger->warning("Momo Service:: $msg");
            throw new \InvalidArgumentException($msg);
        }

        if (is_null($otherData)) {
            $msg = "Please pass the parameter 'network' into the additionalData array";
            $this->logger->error("Momo Service::$msg");
            throw new \InvalidArgumentException($msg);
        }
        $this->isNetworkValid($otherData, $currency);

        $payload = $payload->toArray();

        //request payload
        $body = $payload;

        $type = $this->types[$currency];

        MomoEventHandler::startRecording();
        $request = $this->request($body, 'POST', $type);
        MomoEventHandler::setResponseTime();
        return $this->handleAuthState($request, $body);
    }

    public function save(callable $callback): void
    {
        // TODO: Implement save() method.
    }

    private function isNetworkValid(array $otherData, string $currency): bool
    {
        switch ($currency) {
        case Currency::GHS:
            if (! isset($otherData['network'])) {
                $msg = "network parameter is required.";
                $this->logger->error('Ghana Momo Service::' . $msg);
                throw new \InvalidArgumentException('Ghana Momo Service:' . $msg);
            }
            if (! in_array($otherData['network'], $this->networks['GH'])) {
                $msg = "network passed is not supported.";
                $this->logger->error('Ghana Momo Service::' . $msg);
                throw new \InvalidArgumentException(
                    'Ghana Momo Service: ' . $msg .
                    '. options: ' . json_encode($this->networks['GH'])
                );
            }
            break;
        case Currency::UGX:
            if (! isset($otherData['network'])) {
                $this->logger->error('Uganda Momo Service::network parameter is required.');
                throw new \InvalidArgumentException('Uganda Momo Service: network parameter is required.');
            }
            if (! in_array($otherData['network'], $this->networks['UG'])) {
                $this->logger->error('network passed is not supported for uganda momo.');
                throw new \InvalidArgumentException('Uganda Momo Service: network passed is not supported.');
            }
            break;
        case Currency::ZMW:
            if (! isset($otherData['network'])) {
                $this->logger->error('Zambia Momo Service::network parameter is required.');
                throw new \InvalidArgumentException('Uganda Momo Service: network parameter is required.');
            }
            if (! in_array($otherData['network'], $this->networks['ZM'])) {
                $this->logger->error('network passed is not supported for zambia momo.');
                throw new \InvalidArgumentException('Zambia Momo Service: network passed is not supported.');
            }
            break;
        case Currency::XAF:
            if (! isset($otherData['country'])) {
                $this->logger->error('Franco Momo Service::country parameter is required.');
                throw new \InvalidArgumentException('Franco Momo Service: country parameter is required.');
            }
            if (! in_array($otherData['country'], $this->supported_countries_franco)) {
                $this->logger->error('Franco Momo Service::country passed is not supported.');
                throw new \InvalidArgumentException('Franco Momo Service: country passed is not supported.');
            }
            break;
        }

        return true;
    }

    /**
     * @param  \stdClass $response
     * @param  array     $payload
     * @return array
     */
    private function handleAuthState(\stdClass $response, array $payload): array
    {
        return $this->eventHandler->onAuthorization($response, ['logger' => $this->logger]);
    }
}
