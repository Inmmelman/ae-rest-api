Run commands:
- composer install
- php artisan key:generate
- php artisan migrate
- php db:seed
- php artisan serve

Open http://127.0.0.1:8000/


REST API Endpoints docs
=

**Products api**
=
Get products list:

**Request:** 

url: `GET /api/products`

headers: `Content-Type: application/json`

**Response:** 

Will contains list of  products and data additional
info how to load next page, current page, items per page etc. 

By default per_page size is 10 items.

    "data":{
        "current_page":1,
        "data":[
            {
                "id":1,
                "title":"prod 1",
                "price":10,
                "is_visible":1
            },
            {
                "id":2,
                "title":"prod 2",
                "price":20,
                "is_visible":1
            },
            {
                "id":3,
                "title":"prod 3",
                "price":30,
                "is_visible":1
            }
        ],
        "from":1,
        "next_page_url":null,
        "path":"http://127.0.0.1:8000/api/products",
        "per_page":10,
        "prev_page_url":null,
        "to":3
        }
    }


You can change current page manually with request's parameter **page**:

url: `GET /api/products?page=2`

Set **per_page** parameter to change default amount of items on page:

url: `GET /api/products?per_page=5`

_Show single product:_

Request:

url: `GET /api/products/1`

Example request body:

    "products":
    [   
        {
            "id":1,
            "title":"prod 1",
            "price":10,
            "is_visible":1
        }
    ]


_Create new product:_ 

For create new product must use 
url: `POST /api/products`
and send body with structure:

    "product" : 
        {
            "title" : "test", //string,  title of product
            "price" : 123 // int, product price
        }

For create new product at once with voucher - add to body prop - `voucher_ids`


    "product" : 
        {
            "title" : "test", //string;  title of product
            "price" : 123 // int; product price,
            "voucher_ids": { // array; array of vouchers id
                1,2
            }
        }
        
**_note: If you specify a nonexistent voucher id - the product will still be created but you will see a message about nonexistent voucher_**


_Buy a product:_

For buy product a (set hidden) use

url: `PATCH products/{id}/buy`
where {id} - product id 


**_Discount tires API_**
=
For getting current list of discount tiers use:

Request:

url: `GET /api/discount-tiers`

Response:

    "discounts":[
        {
            "id":1,
            "amount":10
        },
        {
            "id":2,
            "amount":15
        },
        {
            "id":3,
            "amount":20
        },
        {
            "id":4,
            "amount":25
        }
    ]

**_note: only GET request allow_**


**Vouchers API**
=
Get vouchers list:

**Request:** 

url: `GET /api/vouchers`

headers: `Content-Type: application/json`

**Response:** 

Will contains list of  voucher and data additional
info how to load next page, current page, items per page etc. 

By default per_page size is 10 items.

    "data":
        {
            "current_page":2,
            "data":[
                {
                    "id":1,
                    "from":"2017-07-04 02:34:43",
                    "to":"2017-07-01 02:34:43",
                    "discount_tiers_id":1
                }
            ],
            "from":null,
            "next_page_url":null,
            "path":"http:\/\/127.0.0.1:8000\/api\/vouchers",
            "per_page":"10",
            "prev_page_url":"http:\/\/127.0.0.1:8000\/api\/vouchers?per_page=10&page=1",
            "to":null
        }


You can change current page manually with request's parameter **page**:

url: `GET /api/vouchers?page=2`

Set **per_page** parameter to change default amount of items on page:

url: `GET /api/vouchers?per_page=5`


_Create new voucher:_ 

For create new product must use 
url: `POST /api/vouchers`
and send body with structure:

    "voucher" : 
        {
            "discount_tiers_id" : "1", //int,  id of discounts from Discount tires table
            "from" : "2017-07-04 02:14:43", // datetime, date from MUST BE in Y-m-d H:i:s format
            "to" : "2017-07-04 02:14:43" // datetime, date to MUST BE in Y-m-d H:i:s format
        }
**_note: date from MUST be less a date before to_**


Product's vouchers API
=
You can manually `attach` existing voucher to product by API 

**Request:**

url: `PUT /api/products/{product_id}/vouchers/{voucher_id}`

You can manually `detach` existing voucher to product by API
 
 **Request:**
 
 url: `DELETE /api/products/{product_id}/vouchers/{voucher_id}`
