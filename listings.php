<?php
require_once 'inc/utils.php';;
$pageTitle = 'Listings';
require_once 'inc/head.php';
use Lamba\BusinessType\BusinessType;
use Lamba\Listing\ListingSearch;

$categoryId = $categoryReadOnly = $query = $categoryName = '';
if (isset($_GET['categoryId']))
{
    $categoryId = trim($_GET['categoryId']);
    $rsx = BusinessType::getBusinessType($categoryId, ['name']);
    $categoryName = $rsx['name'];
    $categoryReadOnly = 'disabled';
}
if (isset($_GET['query']))
{
    $query = trim($_GET['query']);
}
$arBusinessTypes = BusinessType::getBusinessTypes();
?>

<div id="titlebar" class="gradient">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h2> <?=$pageTitle;?> </h2>
            <nav id="breadcrumbs">
                <ul>
                <li><a href="">Home</a></li>
                <li> <?=$pageTitle;?> </li>
                <?php
                    if ($categoryName != '')
                    {?>
                        <li>Category: <?=$categoryName; ?> </li>
                    <?php
                    }
                ?>
                </ul>
            </nav>
            </div>
      </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-4 col-md-4">
            <div class="sidebar">
                <div class="utf_box_widget margin-bottom-35">
                    <form id="searchForm" onsubmit="return false;">
                        <h3><i class="sl sl-icon-direction"></i> Filters </h3>			
                        <div class="row with-forms">
                            <div class="col-md-12">
                                <input type="text" name="query" id="query" placeholder="What are you looking for?" value="<?=$query;?>">
                            </div>
                        </div>
                        <div class="row with-forms">
                            <div class="col-md-12">
                                <select name="business_type_id" id="business_type_id" <?=$categoryReadOnly;?>>
                                    <option value="all">All</option>
                                    <?php
                                    foreach($arBusinessTypes as $r)
                                    { 
                                        $selected = ($r['id'] == $categoryId) ? 'selected' : '';
                                        ?>
                                        <option value="<?=$r['id'];?>" <?=$selected;?>> <?=$r['name'];?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	
                        <button class="button fullwidth_block margin-top-5" id="btnSubmit">Search</button>
                    </form>
                </div>		  
                <div class="utf_box_widget margin-top-35 margin-bottom-75">
                    <h3><i class="sl sl-icon-folder-alt"></i> Categories</h3>
                    <ul class="utf_listing_detail_sidebar">
                        <?php
                        foreach($arBusinessTypes as $r)
                        { ?>
                            <li><i class="fa fa-angle-double-right"></i> <a href="listings?categoryId=<?=$r['id'];?>"><?=$r['name'];?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 col-md-8">
            <div class="row" id="mainListings">
                <?php
                    echo ListingSearch::getListingsContent($query, $categoryId);
                ?>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="utf_pagination_container_part margin-top-20 margin-bottom-70">
                        <?php
                            echo ListingSearch::getListingsPagination($query, $categoryId);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php
$arAdditionalJs[] = <<<EOQ
function showPagination(page)
{
    if (page <= 0)
    {
        return false;
    }
    else
    {
        $.ajax({
            url: 'inc/actions',
            type: 'POST',
            dataType: 'json',
            data: {
                page: page,
                categoryId: '{$categoryId}',
                query: $('#searchForm #query').val(),
                businessTypeId: $('#searchForm #business_type_id').val(),
                action: 'getListingPaginationData'
            },
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(data)
            {
                if(data.status == true)
                {
                    $("#mainListings").html(data.data['list']);
                    $("#listingsPagination").html(data.data['pagination']);
                }
            }
        });
    }
}
EOQ;

$arAdditionalJsOnLoad[] = <<<EOQ
    $('#searchForm #btnSubmit').click(function()
    {
        var formId = '#searchForm';
        var query = $(formId+' #query').val();

        if (query.length < 3)
        {
            throwError('Your search query is too short');
        }
        else if (query.length > 200)
        {
            throwError('Your search query is too long');
        }
        else
        {
            showPagination(1);
        }
    });
EOQ;
require_once 'inc/foot.php';
?>