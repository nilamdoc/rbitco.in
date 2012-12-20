Coinbase API Documentation

Coinbase provides a simple and powerful REST API to integrate bitcoin payments into your website or mobile app.

If you have any feedback on the API feel free to send us a note.
Getting Started

The base URL for all requests is https://coinbase.com/api/v1/. Requests should go over https and will be redirected if sent to http.
Authentication

Coinbase uses the OAuth2 protocol for authentication. There are good client libraries in most languages due to its widespread use by companies like Google and Facebook. OAuth2 is flexible in that it can be used to access your own account, or other users can grant your application access as well.

OAuth2 comes in two flavors: two-legged and three-legged.

Two-legged is the best choice if you are working on a mobile app, desktop app, or something that does not use a web browser.

Three-legged is the best choice if you are working on a website (where your users are in a web browser).
Registration

To get started you should create an API application and obtain a client_id and client_secret.

You will also be prompted to set a redirect_uri which is a url on your website. If you are using two-legged you won't be using the callback and can set it to https://coinbase.com/callback.
Two-legged OAuth2 Example

To authenticate with two-legged OAuth2:

    Use the client_id and client_secret you obtained during registration along with your email and password to generate an access_token.
    Use this access_token to make API calls to your account.

Ruby example:

require 'oauth2'
client = OAuth2::Client.new(CLIENT_ID, CLIENT_SECRET, site: "https://coinbase.com")
access_token = client.password.get_token('user1@example.com', 'test123!')
puts JSON.parse(access_token.get('/api/v1/account/balance').body)

Note that if you (or the user in question) has two-factor authentication turned on you will also need to pass the token from their cell phone to authenticate the user. Since not all OAuth2 client libraries have support for passing additional fields, we've combined the token field with the username field (separated by a comma).

For example, to pass the two-factor token 1234567 in the previous example you would use access_token = client.password.get_token('user1@example.com,1234567', 'test123!')
Three-legged OAuth2 Example

To authenticate with three-legged OAuth2:

    Use the client_id and client_secret you obtained during registration to generate an authorize_url and redirect the user to this url.
    If the user authorizes your app, they will be returned to the redirect_uri you set during registration (with a code param in the url).
    Use the code param in the url to generate an access_token
    Use this access_token to make API calls on the user's behalf.

Ruby example:

require 'oauth2'
redirect_uri = 'http://www.yourwebsite.com/oauth2/callback' # this must match the url you set during registration
client = OAuth2::Client.new(CLIENT_ID, CLIENT_SECRET, site: 'https://coinbase.com')
`open "#{client.auth_code.authorize_url(redirect_uri: redirect_uri)}"`
print "Enter the code returned in the URL: "
code = STDIN.readline.chomp
token = client.auth_code.get_token(code, redirect_uri: redirect_uri)
puts JSON.parse(token.get('/api/v1/account/balance').body)

OAuth2 Urls

The following paths are used for the OAuth2 authentication flow:

GET       /oauth/authorize      Redirect users here to request access in three-legged OAuth2
POST      /oauth/token          Obtain an access_token

Security Notes

Coinbase uses refresh tokens that expire every two hours. If you are using an OAuth2 library that supports refresh tokens, you won't need to worry about this as the library will take care of it for you. Otherwise, you will have to implement your own logic to refresh access tokens every two hours using the refresh token.

It is also very important that your client application validate our SSL certificate when it connects over https. If you are using a full featured OAuth2 library it most likely has this turned on, but it is worth double checking. If you see a setting to "verify SSL" you should ensure it is set to true.
Resources
Account
Singular resource to check on balance, receive addresses, etc.
Resource 	Description
GET /api/v1/account/balance 	Get the user's account balance in BTC.
GET /api/v1/account/receive_address 	Get the user's current bitcoin receive address.
POST /api/v1/account/generate_receive_address 	Generates a new bitcoin receive address for the user.
Buttons
Create payment buttons to accept bitcoin on your website.
Resource 	Description
POST /api/v1/buttons 	Create a new payment button.
Transactions
Send money, request money, and view transaction history.
Resource 	Description
GET /api/v1/transactions 	List a user's recent transactions.
POST /api/v1/transactions/send_money 	Send bitcoins to an email address or bitcoin address.
POST /api/v1/transactions/request_money 	Send an invoice/money request to an email address.
PUT /api/v1/transactions/:id/resend_request 	Resend emails for a money request.
DELETE /api/v1/transactions/:id/cancel_request 	Cancel a money request.
PUT /api/v1/transactions/:id/complete_request 	Complete a money request.
Users
Create users.
Resource 	Description
POST /api/v1/users 	Create or signup a new user.
