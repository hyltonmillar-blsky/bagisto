# CHANGELOG for v1.x.x

#### This changelog consists the bug & security fixes and new features being included in the releases listed below.

## **v0.1.0(28th of January 2020)** - *Release*

* [feature] Updated to laravel version 6.

* [feature] Added four new product types - Group, Bundle, Downloadable and Virtaul.

* [feature] Povided default theme (Velocity).

* #1971 [fixed] - Filter is not working properly for id column in autogenerated coupon codes in cart rule.

* #1977 [fixed] - On editing the product, selected category for that product is not checked.

* #1978 [fixed] - Getting exception if changing the locale from cart page, if translation is not written for that product.

* #1979 [fixed] - Wrong calculation at customer as well as at admin end in due amount and grandtotal.

* #1983 [fixed] - Getting exception on deleting admin logo.

* #1986 [fixed] - Subscribe to newsletter does not work.

* #1997 [fixed] - Getting exception on adding attribute or creating product in bagisto on php version 7.4 .

* #1998 [fixed] - Showing product sale amount as zero when creating a product, and a existing catalog rule apply on it.

* #2001 [fixed] - php artisan route:list throws error.

* #2012 [fixed] - FGetting exception when clicking on view all under review section at product page.

* #2045 [fixed] - Login option is not coming while checkout with existing customer mail id.

* #2051 [fixed] - Forgot password not working due to recent changes in mail keys.

* #2054 [fixed] -Automatically 1st item of bundle is getting selected as a default after saving product.

* #2058 [fixed] - Not getting any validation message if entered admin credentials are wrong.

* #2066 [fixed] - Exception while writing product review.

* #2071 [fixed] - Customer is not getting forget password email.

* #2074 [fixed] - Getting exception while creating bundle type product.

* #2075 [fixed] - Getting exception if trying to select any parent category of root.

* #2087 [fixed] - Getting exception while adding configurable/bundle/grouped/Downloadable Type product to cart.

* #2088 [fixed] - Getting exception on customer login.

* #2089 [fixed] - Info missing on printing invoice at customer and admin end.

* #2114 [fixed] - getting exception while recovering admin password in case admin did not enter the details in env.

* #2118 [fixed] - Installation issue, getting exception on migrate command.

* #2119 [fixed] - confirm password is not matching even if admin is entering similar password in password and confirm password.

* #2120 [fixed] - Not able to add new user as while creating user password its giving error confirm password doesn't match.

* #2124 [fixed] - Able to make all product as default while creating bundle product in select type option.

* #2128 [fixed] - Click on add attribute, error is thrown.

* #2132 [fixed] - Price range slider not displaying.

* #2145 [fixed] - Emails don't work on registration.

* #2146 [fixed] - Getting exception on creating bundle product without any option.

* #2147 [fixed] - Sort order of bundle product doesn't work..

* #2168 [fixed] - locale direction drop down always select ltr.