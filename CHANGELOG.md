# Changelog

All notable changes to this project will be documented in this file.

## 1.0.0-beta2

- Fixed: InvoiceService::validateCreditCard should pass a single parameter of the arguments as a struct. (#5)
- Added: Created a Token class that stores all information relating to a token.
- Added: Refresh token and end of life now stored alongside the access token.
- Added: `refreshAccessToken()` refreshes the current access token.
- Changed: `getToken()` and `setToken()` are now `getTokenUri()` and `setTokenUri()`. The former function names now get/set the Token object.
- Removed: `getAccessToken()` and `setAccessToken()` are no longer in the `Infusionsoft` class. Use `getToken()` and call the methods on the returned `Token` object.

## 1.0.0-beta1 - 2014-05-14

- Initial release