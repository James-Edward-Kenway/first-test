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
>> ular *brand_id, product_category_id, attributes, order, order_type, store_id*

> ### api url for loading Services
>> http://{ip/hostname}/api/services

```
name = (string) nomidan qidirish
brand_id = (son) brendni idsi **124**
product_category_id = (son) kategoriya idsi **29**
attributes[] = (array) tanlangan atributlani idlari **1**
order = (price|created_at)
order_type = (asc|desc)
store_id = (asc|desc)
photo[] = (rasmlar)


> misol uchun
>> http://{ip/hostname}/api/services?name=iphone&service_category_id=1&attributes[]=1&attribute[]=2&attributes[]=3&order=price&order_type=asc
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
> `kelgan javob attribut kotegoriyalari. misol uchun, "Rangi" bu attribut kotegoriyasi va childrenda barcha attributla joylashgan. misol uchun Rangi:Oq bo'lishi mumkin. produktalani filter qilishda attributlar ning idsi jo'natiladi.`





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

# >> Buyogiga javoblar yozilmay. chunki siz o'rganib qoldingiz. va javobni so'rov yuborib ko'rib bilishingiz mumkin.

# Brands
> brendlani olish
>> http://{ip/hostname}/api/brands

# aksiyalar
> aksiyalarni olish (pagination)
>> http://{ip/hostname}/api/actions

# discountlar
> discountlani olish (pagination)
>> http://{ip/hostname}/api/discounts

# bannerlar
> bannerlani olish (pagination)
>> http://{ip/hostname}/api/banners

# trending products (trendagi produktalar)
> produktalani olish (pagination)
>> http://{ip/hostname}/api/trending_products

# popular services (popularniy servislar)
> servislani olish (pagination)
>> http://{ip/hostname}/api/popular_services

# Registratsiya va login
## Registratsiya

> registratsiya qilish [POST]
>> http://{ip/hostname}/api/user/register?name=(ism familiya)&password=(parol:kami 6 ta belgi)&email=(email@mail.ru)&password_confirmation=(parolni takrorlash)&photo=(photo)&imei=(imei)&version=(4.4)&company=(Samsung A5)

## chiqish

> chiqish qilish (faqat oldin login qilgan userla uchun)
>> http://{ip/hostname}/api/user/logout

## userni o'zgartirish

> userni o'zgartirish (faqat oldin login qilgan userla uchun) [POST]
>> http://{ip/hostname}/api/user/edit?photo=(rasm)&name=(ism)&old_password=(hozirgi paroli)&new_password=(yangi parol)
>> old_password=null bo'ladi agar parol o'zgartirimasa

## Login

> login qilish
>> http://{ip/hostname}/api/user/login?email=(email@mail.ru)&password=(parol:kami 6 ta belgi)&imei=(imei)&version=(4.4)&company=(Samsung A5)
> agar registratsiya yoki login muvafaqiyatli bo'lsa {'authorized'=>true}, agar qandaydir xatolik bo'lsa {'authorized'=>false} bo'ladi. va ketidan oshibka messagi keladi.
> login registratsiyadan keyin token keladi. shu tokenni va user_id ni har bir so'rovda yuborish kerak. 
>> yangi usulga binoan token bn user_id headerga qo'shib yuboriladigan bo'ldi. bunda user_id -> `xx-user-id: 35` bo'lib token -> `xx-token: ajsdklfjskldjflkajdlkjasd` qilib jo'natiladi.

## Registratsiya google bilan

> registratsiya qilish google bilan
>> http://{ip/hostname}/api/user/google_register?name=(ism familiya)&google_id=(google user id)&photo_url=(googledan kelgan fotoning idisi bo'lishi kerak)&email=(email@mail.ru)&imei=(imei)&version=(4.4)&company=(Samsung A5)

## Login google bilan

> login qilish
>> http://{ip/hostname}/api/user/google_login?google_id=(user idisi)&imei=(imei)&version=(4.4)&company=(Samsung A5)


## Token reset
> yangi token olish
>> http://{ip/hostname}/api/user/token?user_id=(user_id)&token=(token)

# Magazinlar
> user registratsiya yoki login qilgan bo'lishi shart!

## foydalanuvchining barcha magazinlari
> magazinlar foydalanuvchiga qarashli
>> http://{ip/hostname}/api/store/mystores

## Qo'shish
> magazin qo'shish [POST]
>> http://{ip/hostname}/api/store/add?name=(nomi)&description=(tarifi)&address=(address)&phone=(tel nomeri)&photo=alskjfdlk

## O'chirish
> magazin O'chirish
>> http://{ip/hostname}/api/store/delete?store_id=(magazin idsi)

## O'zgartirish
> magazin O'zgartirish [POST]
>> http://{ip/hostname}/api/store/update?store_id=(magazin idsi)&name=(nomi)&description=(tarifi)&address=(address)&phone=(tel nomeri)

## Olish
> magazin haqidagi informatsiyani olish (*registratsiya bo'lishi shartmas!*)
>> http://{ip/hostname}/api/store/show?store_id=(magazin idsi)

## magazin uchun userda mavjud bo'lgan rollani olish
> magazin rollari
>> http://{ip/hostname}/api/store/roles?store_id=(magazin idisi)
```
    const SUPERUSER = 1; // superuser; hamma ish qilishi mumkin; magazinning yaratuvchisi
    const UPDATE_ROLES = 2; // ro'llani o'zgartira olishini aniqlovchi ro'l
    const STORE_DELETE = 3; // magazinni o'chira oladimi
    const STORE_UPDATE = 4; // magazin malumotlarini o'zgartira oladimi
    const ADD_PRODUCT = 5; // produkta qo'sha oladimi
    const ADD_SERVICE = 6; // servis qo'sha oladimi
    const DELETE_PRODUCT = 7; // produkta o'chira oladimi
    const DELETE_SERVICE = 8; // servis o'chira oladimi
    const UPDATE_PRODUCT = 9; // produkta ma'l larini o'zgartira oladimi
    const UPDATE_SERVICE = 10; // servis ma'l larini o'zgartira oladimi
    const ADD_ACTION = 11; // aksiya qo'sha oladimi
    const ADD_DISCOUNT = 12; // skidkalani qo'shish
    const DELETE_ACTION = 13; // aksiyalani o'chirish
    const DELETE_DISCOUNT = 14; // skidkalani o'chirish
    const UPDATE_ACTION = 15; // aksiyalarning ma'l larini o'zgartirish
    const UPDATE_DISCOUNT = 16; // skidkalarning ma'l larini o'zgartirish
```

## magazin produktalari mavjud bo'lgan kategoriyalarni olish
> magazin product_categories
>> http://{ip/hostname}/api/store/product_categories?store_id=(magazin idisi)

## magazin servislari mavjud bo'lgan kategoriyalarni olish
> magazin service_categories
>> http://{ip/hostname}/api/store/service_categories?store_id=(magazin idisi)

# wishlist (izabrannie)

> wishlist (product_id lani beradi! faqat id lani beradi!)
>> http://{ip/hostname}/api/user/wishlist_product_ids

> wishlist (service_id lani beradi! faqat id lani beradi!)
>> http://{ip/hostname}/api/user/wishlist_service_ids

> wishlist (productlani olish!)
>> http://{ip/hostname}/api/user/wishlist_products

> wishlist (servicelani olish!)
>> http://{ip/hostname}/api/user/wishlist_services

> wishlist (servicelani qo'shish!)
>> http://{ip/hostname}/api/user/add_wishlist_service?service_id=(qo'shilishi kerak bo'lgan service idisi)

> wishlist (productlani qo'shish!)
>> http://{ip/hostname}/api/user/add_wishlist_product?product_id=(qo'shilishi kerak bo'lgan product idisi)

> wishlist (servicelani o'chirish!)
>> http://{ip/hostname}/api/user/delete_wishlist_service?service_id=(o'chirilishi kerak bo'lgan service idisi)

> wishlist (productlani o'chirish!)
>> http://{ip/hostname}/api/user/delete_wishlist_product?product_id=(o'chirilishi kerak bo'lgan product idisi)

# Likes (layklar)

> likes (product_id lani beradi! faqat id lani beradi!)
>> http://{ip/hostname}/api/user/product_likes_ids

> likes (service_id lani beradi! faqat id lani beradi!)
>> http://{ip/hostname}/api/user/service_likes_ids


> likes (product lani beradi!)
>> http://{ip/hostname}/api/user/product_likes

> likes (service lani beradi!)
>> http://{ip/hostname}/api/user/service_likes


> likes (product lani qo'shish!)
>> http://{ip/hostname}/api/user/add_product_likes?product_id=(qo'shilishi kerak bo'lgan produktani idisi)

> likes (service lani qo'shish!)
>> http://{ip/hostname}/api/user/add_service_likes?service_id=(qo'shilishi kerak bo'lgan serviceni idisi)


> likes (product lani o'chirish!)
>> http://{ip/hostname}/api/user/delete_product_likes?product_id=(o'chirish kerak bo'lgan produktani idisi)

> likes (service lani o'chirish!)
>> http://{ip/hostname}/api/user/delete_service_likes?service_id=(o'chirish kerak bo'lgan serviceni idisi


# products
> productalani o'zgartirish uchun user registratsiyadan o'tgan bo'lishi kerak!

> productalani qo'shish (hozircha shu!) [POST]
>> http://{ip/hostname}/api/store/add_product?name=(nomi)&category_id=(kategory_id)&description=(tarifi)&store_id=(magazin id)&price=(product price)&brand_id=(tanlangan brend_id)

> productalani o'zgartiring (hozircha shu!) [POST]
>> http://{ip/hostname}/api/store/update_product?product_id=(o'zgartirilishi kerak bo'lgan product idisi)&category_id=(kategory_id)&name=(nomi)&description=(tarifi)&store_id=(magazin id)&price=(product price)&brand_id=(tanlangan brend_id)

> productalani o'chirish (hozircha shu!)
>> http://{ip/hostname}/api/store/delete_product?product_id=(o'zgartirilishi kerak bo'lgan product idisi)&store_id=(magazin id)


# services
> servislani o'zgartirish uchun user registratsiyadan o'tgan bo'lishi kerak!

> servislani qo'shish (hozircha shu!) [POST]
>> http://{ip/hostname}/api/store/add_service?name=(nomi)&category_id=(service kategory idisi)&description=(tarifi)&store_id=(magazin id)&price=(service price)

> servislani o'zgartishi (hozircha shu!) [POST]
>> http://{ip/hostname}/api/store/update_service?service_id=(o'zgarilishi kerak bo'lgan servis idisi)&name=(nomi)&description=(tarifi)&store_id=(magazin id)&category_id=(service kategory idisi)&price=(service price)

> servislani o'chirish (hozircha shu!)
>> http://{ip/hostname}/api/store/delete_service?service_id=(o'chirilishi kerak bo'lgan servis idisi)&store_id=(magazin id)


# actions (aksiyalar)
> aksiyalani o'zgartirish uchun user registratsiyadan o'tgan bo'lishi kerak!

> aksiyalani qo'shish (hozircha shu!) [POST]
>> http://{ip/hostname}/api/store/add_action?title=(sarlovhasi)&description=(tarifi)&store_id=(magazin id)&address=(address)

> aksiyalani o'zgartirish (hozircha shu!) [POST]
>> http://{ip/hostname}/api/store/update_action?action_id=(aksiyani idisi)&title=(sarlovhasi)&description=(tarifi)&store_id=(magazin id)&address=(address)

> aksiyalani o'chirish (hozircha shu!)
>> http://{ip/hostname}/api/store/delete_discount?action_id(aksiya idisi)&store_id=(magazin id)

# discount (skidkala)
> skidkalani o'zgartirish uchun user registratsiyadan o'tgan bo'lishi kerak!

> skidkalani qo'shish (hozircha shu!) [POST]
>> http://{ip/hostname}/api/store/add_discount?title=(sarlovhasi)&description=(tarifi)&store_id=(magazin id)&discount=(service price)&address=(address)

> skidkalani o'zgartirish (hozircha shu!) [POST]
>> http://{ip/hostname}/api/store/update_discount?discount_id(skidka idisi)&title=(sarlovhasi)&description=(tarifi)&store_id=(magazin id)&discount=(service price)&address=(address)

> skidkalani o'chirish (hozircha shu!)
>> http://{ip/hostname}/api/store/delete_discount?discount_id(skidka idisi)&store_id=(magazin id)

# images 
> imagela json array formatda keladi. ulani parse qilish kerak. va undan keyin asosiy urlga qo'shish kerak
`misol: /images/store/31/64f1cc2df3bfc9f09c8ad714137aeb85.jpg, kelsa uni http://{ip/hostname}/images/store/31/64f1cc2df3bfc9f09c8ad714137aeb85.jpg, qilish kerak va so'roni ham shunga yuborish kerak.`

# Exceptions (Istesno holatlar)

`http response kodlari: 401 - registratsiya yoki login qilinishi kerak bo'lgan bo'limlarga. registratsiya yoki login qilmagan user so'rov yuborsa holat kelib chiqishi mumkin!`
`http response kodlari: 405 - to'g'ri permission bo'lmaganda kelib chiqadi, yani magazin egasi bo'lmagan odam magazin malumotlarini o'zgartishga intilsa sodir bo'ladi!`