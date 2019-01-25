# asiagood documentation for backend Restful api

### Home api request

> api url for the home page loading
>> http://{ip/hostname}/api/home

### response to the request above
```
{
  "brand": [
    {
      "id": 1,
      "order": 0,
      "name": "{\"uz\":\"Apple\",\"ru\":\"Apple\"}",
      "image64": "http://url/ok",
      "image128": "http://url/ok",
      "created_at": "2019-01-24 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    },
    {
      "id": 2,
      "order": 0,
      "name": "{\"uz\":\"Microsoft\",\"ru\":\"Microsoft\"}",
      "image64": "http://url/ok",
      "image128": "http://url/ok",
      "created_at": "2019-01-24 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    }
  ],
  "service_category": [
    {
      "id": 1,
      "parent_id": 0,
      "order": 0,
      "name": "{\"uz\":\"Electronics\",\"ru\":\"Electronics\"}",
      "image64": "http://url",
      "image128": "http://url",
      "created_at": "2019-01-30 00:00:00",
      "updated_at": "2019-01-30 00:00:00"
    },
    {
      "id": 2,
      "parent_id": 0,
      "order": 0,
      "name": "{\"uz\":\"Electronics\",\"ru\":\"Electronics\"}",
      "image64": "http://url",
      "image128": "http://url",
      "created_at": "2019-01-24 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    }
  ],
  "product_category": [
    {
      "id": 1,
      "parent_id": 0,
      "order": 0,
      "name": "{\"uz\":\"Electronics\",\"ru\":\"Electronics\"}",
      "image64": "http://url",
      "image128": "http://url",
      "created_at": "2019-01-30 00:00:00",
      "updated_at": "2019-01-30 00:00:00"
    },
    {
      "id": 2,
      "parent_id": 0,
      "order": 0,
      "name": "{\"uz\":\"Electronics\",\"ru\":\"Electronics\"}",
      "image64": "http://url",
      "image128": "http://url",
      "created_at": "2019-01-24 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    }
  ]
}
```
# Service Categories api request

> api url for the service categories data loading
>>http://{ip/hostname}/api/sub_service_category/{id}
>>>id = service_category_id `example: http://{ip/hostname}/api/sub_service_category/1`

> api url for the product categories data loading
>>http://{ip/hostname}/api/sub_product_category/{id}
>>>id = product_category_id `example: http://{ip/hostname}/api/sub_product_category/1`

`product category and service category works in the same way!`
### response to the request above
```
[
  {
    "id": 3,
    "parent_id": 1,
    "order": 0,
    "name": "{\"uz\":\"Electronics 1\",\"ru\":\"Electronics 1\"}",
    "image64": "http://url/or/ip",
    "image128": "http://url/or/ip",
    "created_at": "2019-01-31 00:00:00",
    "updated_at": "2019-01-31 00:00:00",
    "children": [
      {
        "id": 5,
        "parent_id": 3,
        "order": 0,
        "name": "{\"uz\":\"Electronics 1-1\",\"ru\":\"Electronics 1-1\"}",
        "image64": "http://url/or/ip",
        "image128": "http://url/or/ip",
        "created_at": "2019-01-31 00:00:00",
        "updated_at": "2019-01-31 00:00:00"
      },
      {
        "id": 6,
        "parent_id": 3,
        "order": 0,
        "name": "{\"uz\":\"Electronics 1-2\",\"ru\":\"Electronics 1-2\"}",
        "image64": "http://url/or/ip",
        "image128": "http://url/or/ip",
        "created_at": "2019-01-31 00:00:00",
        "updated_at": "2019-01-30 00:00:00"
      }
    ]
  },
  {
    "id": 4,
    "parent_id": 1,
    "order": 0,
    "name": "{\"uz\":\"Electronics 2\",\"ru\":\"Electronics 2\"}",
    "image64": "http://url/or/ip",
    "image128": "http://url/or/ip",
    "created_at": "2019-01-31 00:00:00",
    "updated_at": "2019-01-30 00:00:00",
    "children": [
      {
        "id": 7,
        "parent_id": 4,
        "order": 0,
        "name": "{\"uz\":\"Electronics 2-1\",\"ru\":\"Electronics 2-1\"}",
        "image64": "http://url/or/ip",
        "image128": "http://url/or/ip",
        "created_at": "2019-01-31 00:00:00",
        "updated_at": "2019-01-31 00:00:00"
      },
      {
        "id": 8,
        "parent_id": 4,
        "order": 0,
        "name": "{\"uz\":\"Electronics 2-1\",\"ru\":\"Electronics 2-2\"}",
        "image64": "http://url/or/ip",
        "image128": "http://url/or/ip",
        "created_at": "2019-01-31 00:00:00",
        "updated_at": "2019-01-30 00:00:00"
      }
    ]
  }
]
```

# Products va Services api request

> ### api url for loading Products
>> http://{ip/hostname}/api/products
>> bunda bir nechta attributla mavjud
>> bu attributlani hech biri ajburiy emas
>> ular *brand_id, product_category_id, attributes, order, order_type*

> ### api url for loading Services
>> http://{ip/hostname}/api/services

```
name = (string) nomidan qidirish
brand_id = (son) brendni idsi **124**
product_category_id = (son) kategoriya idsi **29**
attributes = (array) tanlangan atributlani idlari **[1,2,3,7,5]**
order = (price|created_at)
order_type = (asc|desc)

serviceladayam shular bor lekin *product_category_id* ni o'rnida *service_category_id* bo'ladi.
```

### Apidan kelgan javob produkta uchun


```
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "product_category_id": 10,
      "brand_id": 1,
      "user_id": 1,
      "title": "Real Title of the product but fake",
      "description": "Real Title of the product but fakeReal Title of the product but fakeReal Title of the product but fakeReal Title of the product but fake",
      "image": "ss",
      "price": "3600.00",
      "created_at": "2019-01-31 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    },
    {
      "id": 2,
      "product_category_id": 10,
      "brand_id": 1,
      "user_id": 1,
      "title": "2222Real Title of the product but fake",
      "description": "222Real Title of the product but fakeReal Title of the product but fakeReal Title of the product but fakeReal Title of the product but fake",
      "image": "ss",
      "price": "3600.00",
      "created_at": "2019-01-31 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    },
    {
      "id": 3,
      "product_category_id": 10,
      "brand_id": 1,
      "user_id": 1,
      "title": "525 Title of the product but fake",
      "description": "252525 Title of the product but fakeReal Title of the product but fakeReal Title of the product but fakeReal Title of the product but fake",
      "image": "ss",
      "price": "3600.00",
      "created_at": "2019-01-31 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    }
  ],
  "first_page_url": "http://j.asiagood.uz/api/products?page=1&order=id&order_type=asc",
  "from": 1,
  "last_page": 1,
  "last_page_url": "http://j.asiagood.uz/api/products?page=1&order=id&order_type=asc",
  "next_page_url": null,
  "path": "http://j.asiagood.uz/api/products",
  "per_page": 20,
  "prev_page_url": null,
  "to": 3,
  "total": 3
}
```

## filterda kotegoriyani tanlaganda filter uchun ishlatiladigan attribute laga so'rov jo'natiladi.
> chunki attribute la kotegoriyaga qarab o'zgaradi.

### kotegoriya tanlanganda kelishi kerak bo'lgan filterlar

>> http://{ip/hostname}/api/product_attributes/{id}
>>> id = (son) produktalani kotegoriyasini idsi

>> http://{ip/hostname}/api/service_attributes/{id}
>>> id = (son) servislani kotegoriyasini idsi
> `kelgan javob attribut kotegoriyalari. misol uchun, "Rangi" bu attribut kotegoriyasi va childrenda barcha attributla joylashgan. misol uchun Rangi:Oq bo'lishi mumkin.`

```
[
  {
    "id": 1,
    "order": 0,
    "name": "{\"uz\":\"Rangi\",\"ru\":\"Color\"}",
    "created_at": "2019-01-30 00:00:00",
    "updated_at": "2019-01-30 00:00:00",
    "pivot": {
      "product_category_id": 1,
      "attribute_category_id": 1
    },
    "children": [
      {
        "id": 1,
        "attribute_category_id": 1,
        "title": "{\"uz\":\"Oq\",\"ru\":\"White\"}",
        "created_at": "2019-01-29 00:00:00",
        "updated_at": "2019-01-29 00:00:00"
      },
      {
        "id": 2,
        "attribute_category_id": 1,
        "title": "{\"uz\":\"Qora\",\"ru\":\"Black\"}",
        "created_at": "2019-01-23 00:00:00",
        "updated_at": "2019-01-23 00:00:00"
      }
    ]
  },
  {
    "id": 2,
    "order": 0,
    "name": "{\"uz\":\"O\\'lchami\",\"ru\":\"Size\"}",
    "created_at": "2019-01-30 00:00:00",
    "updated_at": "2019-01-30 00:00:00",
    "pivot": {
      "product_category_id": 1,
      "attribute_category_id": 2
    },
    "children": [
      {
        "id": 3,
        "attribute_category_id": 2,
        "title": "{\"uz\":\"2x2\",\"ru\":\"5x5\"}",
        "created_at": "2019-01-29 00:00:00",
        "updated_at": "2019-01-29 00:00:00"
      },
      {
        "id": 4,
        "attribute_category_id": 2,
        "title": "{\"uz\":\"3x3\",\"ru\":\"5x5\"}",
        "created_at": "2019-01-23 00:00:00",
        "updated_at": "2019-01-23 00:00:00"
      }
    ]
  }
]
```