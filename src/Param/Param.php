<?php
namespace Lamba\Param;

class Param
{
    public static function getRequestParams($action)
    {
        $data = [];
        switch($action)
        {
            case 'register':
                $data = [
                    'fname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'First Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'lname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Last Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'email' => [
                        'method' => 'post',
                        'length' => [13,200],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ],
                    'password1' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Password',
                        'required' => true
                    ],
                    'password2' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Confirm Password',
                        'required' => true
                    ],
                ];
            break;

            case 'login':
                $data = [
                    'email' => [
                        'method' => 'post',
                        'length' => [13,200],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ],
                    'password' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Password',
                        'required' => true
                    ]
                ];
            break;

            case 'changepassword':
                $data = [
                    'current_password' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Current Password',
                        'required' => true
                    ],
                    'new_password' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'New Password',
                        'required' => true
                    ],
                    'confirm_password' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Confirm Password',
                        'required' => true
                    ]
                ];
            break;

            case 'updateprofile':
                $data = [
                    'fname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'First Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'lname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Last Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'email' => [
                        'method' => 'post',
                        'length' => [13,200],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ],
                    'phone' => [
                        'method' => 'post',
                        'length' => [11,15],
                        'label' => 'Phone',
                        'required' => true
                    ],
                    'business_name' => [
                        'method' => 'post',
                        'length' => [5,200],
                        'label' => 'Business Name',
                        'required' => true
                    ],
                    'business_info' => [
                        'method' => 'post',
                        'length' => [20,0],
                        'label' => 'Business Description',
                        'required' => true
                    ],
                    'aaddress_street' => [
                        'method' => 'post',
                        'length' => [20,200],
                        'label' => 'Street Address'
                    ],
                    'address_city' => [
                        'method' => 'post',
                        'length' => [3,30],
                        'label' => 'City',
                        'required' => true
                    ],
                    'address_state' => [
                        'method' => 'post',
                        'length' => [3,30],
                        'label' => 'State',
                        'required' => true
                    ],
                    'facebook' => [
                        'method' => 'post',
                        'length' => [27,0],
                        'label' => 'Facebook Link'
                    ],
                    'instagram' => [
                        'method' => 'post',
                        'length' => [26,0],
                        'label' => 'Instagram Link'
                    ],
                    'twitter' => [
                        'method' => 'post',
                        'length' => [26,0],
                        'label' => 'Twitter Link'
                    ],
                ];
            break;

            case 'addlisting':
                $data = [
                    'title' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Title',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'short_desc' => [
                        'method' => 'post',
                        'length' => [20,400],
                        'label' => 'Short Description'
                    ],
                    'full_desc' => [
                        'method' => 'post',
                        'length' => [20,0],
                        'label' => 'Full Description',
                        'required' => true
                    ]
                ];
            break;

            case 'addreview':
                $data = [
                    'name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'name',
                        'required' => true
                    ],
                    'email' => [
                        'method' => 'post',
                        'length' => [13,100],
                        'label' => 'Email'
                    ],
                    'msg' => [
                        'method' => 'post',
                        'length' => [5,0],
                        'label' => 'Comment',
                        'required' => true
                    ],
                    'listing_id' => [
                        'method' => 'post',
                        'length' => [36,36],
                        'label' => 'Listing',
                        'required' => true
                    ]
                ];
            break;
        }
        return $data;
    }
}