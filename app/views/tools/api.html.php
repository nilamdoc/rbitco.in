<div><h1 class='page-header'>rBitCo.in API Documentation</h1>
<!--
<p>rBitCo.in provides a simple and powerful REST API to integrate bitcoin payments into your website or mobile app.</p>

<p>If you have any feedback on the API feel free to <a href="https://rBitCo.in.com/help">send us a note</a>.</p>

<h1 class='page-header'>Getting Started</h1>

<p>The base URL for all requests is <code>https://rBitCo.in.com/api/v1/</code>.  Requests should go over <code>https</code> and will be redirected if sent to <code>http</code>.</p>

<h2>Authentication</h2>

<p>rBitCo.in uses the <a href="http://en.wikipedia.org/wiki/OAuth#OAuth_2.0">OAuth2</a> protocol for authentication.  There are good client libraries in most languages due to its widespread use by companies like Google and Facebook.  OAuth2 is flexible in that it can be used to access your own account, or other users can grant your application access as well.</p>

<p>OAuth2 comes in two flavors: two-legged and three-legged.</p>

<p>Two-legged is the best choice if you are working on a mobile app, desktop app, or something that does not use a web browser.</p>

<p>Three-legged is the best choice if you are working on a website (where your users are in a web browser).</p>

<h3>Registration</h3>

<p>To get started you should <a href="/oauth/applications">create an API application</a> and obtain a <code>client_id</code> and <code>client_secret</code>.</p>

<p>You will also be prompted to set a <code>redirect_uri</code> which is a url on your website.  If you are using two-legged you won&#39;t be using the callback and can set it to <code>https://rBitCo.in.com/callback</code>.</p>

<h3>Two-legged OAuth2 Example</h3>

<p>To authenticate with two-legged OAuth2:</p>

<ul>
<li>Use the <code>client_id</code> and <code>client_secret</code> you obtained during registration along with your <code>email</code> and <code>password</code> to generate an <code>access_token</code>.</li>
<li>Use this <code>access_token</code> to make API calls to your account.</li>
</ul>

<p>Ruby example:</p>

<pre><code>require &#39;oauth2&#39;
client = OAuth2::Client.new(CLIENT_ID, CLIENT_SECRET, site: &quot;https://rBitCo.in.com&quot;)
access_token = client.password.get_token(&#39;user1@example.com&#39;, &#39;test123!&#39;)
puts JSON.parse(access_token.get(&#39;/api/v1/account/balance&#39;).body)
</code></pre>

<p>Note that if you (or the user in question) has two-factor authentication turned on you will also need to pass the token from their cell phone to authenticate the user.  Since not all OAuth2 client libraries have support for passing additional fields, we&#39;ve combined the token field  with the username field (separated by a comma).</p>

<p>For example, to pass the two-factor token <code>1234567</code> in the previous example you would use <code>access_token = client.password.get_token(&#39;user1@example.com,1234567&#39;, &#39;test123!&#39;)</code></p>

<h3>Three-legged OAuth2 Example</h3>

<p>To authenticate with three-legged OAuth2:</p>

<ul>
<li>Use the <code>client_id</code> and <code>client_secret</code> you obtained during registration to generate an <code>authorize_url</code> and redirect the user to this url.</li>
<li>If the user authorizes your app, they will be returned to the <code>redirect_uri</code> you set during registration (with a <code>code</code> param in the url).</li>
<li>Use the <code>code</code> param in the url to generate an <code>access_token</code></li>
<li>Use this <code>access_token</code> to make API calls on the user&#39;s behalf.</li>
</ul>

<p>Ruby example:</p>

<pre><code>require &#39;oauth2&#39;
redirect_uri = &#39;http://www.yourwebsite.com/oauth2/callback&#39; # this must match the url you set during registration
client = OAuth2::Client.new(CLIENT_ID, CLIENT_SECRET, site: &#39;https://rBitCo.in.com&#39;)
`open &quot;#{client.auth_code.authorize_url(redirect_uri: redirect_uri)}&quot;`
print &quot;Enter the code returned in the URL: &quot;
code = STDIN.readline.chomp
token = client.auth_code.get_token(code, redirect_uri: redirect_uri)
puts JSON.parse(token.get(&#39;/api/v1/account/balance&#39;).body)
</code></pre>

<h3>OAuth2 Urls</h3>

<p>The following paths are used for the OAuth2 authentication flow:</p>

<pre><code>GET       /oauth/authorize      Redirect users here to request access in three-legged OAuth2
POST      /oauth/token          Obtain an access_token
</code></pre>

<h3>Security Notes</h3>

<p>rBitCo.in uses <a href="http://tools.ietf.org/html/draft-ietf-oauth-v2-22#section-1.5">refresh tokens</a> that expire every two hours.  If you are using an OAuth2 library that supports refresh tokens, you won&#39;t need to worry about this as the library will take care of it for you.  Otherwise, you will have to implement your own logic to refresh access tokens every two hours using the refresh token.</p>

<p>It is also very important that your client application validate our SSL certificate when it connects over https.  If you are using a full featured OAuth2 library it most likely has this turned on, but it is worth double checking.  If you see a setting to &quot;verify SSL&quot; you should ensure it is set to true.</p>
</div>

<h1 class='page-header'>Resources</h1>

  <h2>
    <a href='/api/doc/accounts.html'>Account</a><br>
    <small>Singular resource to check on balance, receive addresses, etc.</small>
  </h2>
  <table class='table'>
    <thead>
      <tr>
        <th>Resource</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
          <tr>
            <td><a href='/api/doc/accounts/balance.html'>GET /api/v1/account/balance</a></td>
            <td width='60%'>Get the user&#x27;s account balance in BTC.</td>
          </tr>
          <tr>
            <td><a href='/api/doc/accounts/receive_address.html'>GET /api/v1/account/receive_address</a></td>
            <td width='60%'>Get the user&#x27;s current bitcoin receive address.</td>
          </tr>
          <tr>
            <td><a href='/api/doc/accounts/generate_receive_address.html'>POST /api/v1/account/generate_receive_address</a></td>
            <td width='60%'>Generates a new bitcoin receive address for the user.</td>
          </tr>
    </tbody>
  </table>
  <h2>
    <a href='/api/doc/buttons.html'>Buttons</a><br>
    <small>Create payment buttons to accept bitcoin on your website.</small>
  </h2>
  <table class='table'>
    <thead>
      <tr>
        <th>Resource</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
          <tr>
            <td><a href='/api/doc/buttons/create.html'>POST /api/v1/buttons</a></td>
            <td width='60%'>Create a new payment button.</td>
          </tr>
    </tbody>
  </table>
  <h2>
    <a href='/api/doc/transactions.html'>Transactions</a><br>
    <small>Send money, request money, and view transaction history.</small>
  </h2>
  <table class='table'>
    <thead>
      <tr>
        <th>Resource</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
          <tr>
            <td><a href='/api/doc/transactions/index.html'>GET /api/v1/transactions</a></td>
            <td width='60%'>List a user&#x27;s recent transactions.</td>
          </tr>
          <tr>
            <td><a href='/api/doc/transactions/send_money.html'>POST /api/v1/transactions/send_money</a></td>
            <td width='60%'>Send bitcoins to an email address or bitcoin address.</td>
          </tr>
          <tr>
            <td><a href='/api/doc/transactions/request_money.html'>POST /api/v1/transactions/request_money</a></td>
            <td width='60%'>Send an invoice/money request to an email address.</td>
          </tr>
          <tr>
            <td><a href='/api/doc/transactions/resend_request.html'>PUT /api/v1/transactions/:id/resend_request</a></td>
            <td width='60%'>Resend emails for a money request.</td>
          </tr>
          <tr>
            <td><a href='/api/doc/transactions/cancel_request.html'>DELETE /api/v1/transactions/:id/cancel_request</a></td>
            <td width='60%'>Cancel a money request.</td>
          </tr>
          <tr>
            <td><a href='/api/doc/transactions/complete_request.html'>PUT /api/v1/transactions/:id/complete_request</a></td>
            <td width='60%'>Complete a money request.</td>
          </tr>
    </tbody>
  </table>
  <h2>
    <a href='/api/doc/users.html'>Users</a><br>
    <small>Create users.</small>
  </h2>
  <table class='table'>
    <thead>
      <tr>
        <th>Resource</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
          <tr>
            <td><a href='/api/doc/users/create.html'>POST /api/v1/users</a></td>
            <td width='60%'>Create or signup a new user.</td>
          </tr>
    </tbody>
  </table>
  </div>
  -->
  Comeing soon...