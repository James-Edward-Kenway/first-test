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