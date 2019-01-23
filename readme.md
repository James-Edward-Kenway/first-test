# asiagood documentation for backend Restful api

[Home api request]

# api url for the home page loading

{http://address.uz/api/home}

# response to the request above
```
{
  "brand": [
    {
      "id": 1,
      "name": "{\"uz\":\"Apple\",\"ru\":\"Apple\"}",
      "image64": "http://url/ok",
      "image128": "http://url/ok",
      "created_at": "2019-01-24 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    },
    {
      "id": 2,
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
      "name": "{\"uz\":\"Electronics\",\"ru\":\"Electronics\"}",
      "image64": "http://url",
      "image128": "http://url",
      "created_at": "2019-01-30 00:00:00",
      "updated_at": "2019-01-30 00:00:00"
    },
    {
      "id": 2,
      "parent_id": 0,
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
      "name": "{\"uz\":\"Electronics\",\"ru\":\"Electronics\"}",
      "image64": "http://url",
      "image128": "http://url",
      "created_at": "2019-01-30 00:00:00",
      "updated_at": "2019-01-30 00:00:00"
    },
    {
      "id": 2,
      "parent_id": 0,
      "name": "{\"uz\":\"Electronics\",\"ru\":\"Electronics\"}",
      "image64": "http://url",
      "image128": "http://url",
      "created_at": "2019-01-24 00:00:00",
      "updated_at": "2019-01-24 00:00:00"
    }
  ]
}
```