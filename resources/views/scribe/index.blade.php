<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Altara Customer Facing App API</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var baseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("vendor/scribe/js/tryitout-3.24.0.js") }}"></script>

    <script src="{{ asset("vendor/scribe/js/theme-default-3.24.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                                                                            <ul id="tocify-header-0" class="tocify-header">
                    <li class="tocify-item level-1" data-unique="introduction">
                        <a href="#introduction">Introduction</a>
                    </li>
                                            
                                                                    </ul>
                                                <ul id="tocify-header-1" class="tocify-header">
                    <li class="tocify-item level-1" data-unique="authenticating-requests">
                        <a href="#authenticating-requests">Authenticating requests</a>
                    </li>
                                            
                                                </ul>
                    
                    <ul id="tocify-header-2" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authentication">
                    <a href="#authentication">Authentication</a>
                </li>
                                    <ul id="tocify-subheader-authentication" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-auth-login">
                        <a href="#authentication-POSTapi-v1-auth-login">Login</a>
                    </li>
                                    <li class="tocify-item level-2" data-unique="authentication-GETapi-v1-auth-user">
                        <a href="#authentication-GETapi-v1-auth-user">Authenticated Customer</a>
                    </li>
                                    <li class="tocify-item level-2" data-unique="authentication-GETapi-v1-auth-logout">
                        <a href="#authentication-GETapi-v1-auth-logout">Logout</a>
                    </li>
                                                    </ul>
                            </ul>
                    <ul id="tocify-header-3" class="tocify-header">
                <li class="tocify-item level-1" data-unique="customer">
                    <a href="#customer">Customer</a>
                </li>
                                    <ul id="tocify-subheader-customer" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="customer-PATCHapi-v1-customers--customer-">
                        <a href="#customer-PATCHapi-v1-customers--customer-">Update Profile</a>
                    </li>
                                                    </ul>
                            </ul>
                    <ul id="tocify-header-4" class="tocify-header">
                <li class="tocify-item level-1" data-unique="customer-order">
                    <a href="#customer-order">Customer Order</a>
                </li>
                                    <ul id="tocify-subheader-customer-order" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="customer-order-GETapi-v1-customers--customer--orders">
                        <a href="#customer-order-GETapi-v1-customers--customer--orders">All Customer Orders</a>
                    </li>
                                    <li class="tocify-item level-2" data-unique="customer-order-POSTapi-v1-submit-request">
                        <a href="#customer-order-POSTapi-v1-submit-request">Apply for Orders</a>
                    </li>
                                                    </ul>
                            </ul>
                    <ul id="tocify-header-5" class="tocify-header">
                <li class="tocify-item level-1" data-unique="document">
                    <a href="#document">Document</a>
                </li>
                                    <ul id="tocify-subheader-document" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="document-POSTapi-v1-document-upload">
                        <a href="#document-POSTapi-v1-document-upload">Upload</a>
                    </li>
                                                    </ul>
                            </ul>
                    <ul id="tocify-header-6" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-user">
                        <a href="#endpoints-GETapi-user">GET api/user</a>
                    </li>
                                                    </ul>
                            </ul>
                    <ul id="tocify-header-7" class="tocify-header">
                <li class="tocify-item level-1" data-unique="notifications">
                    <a href="#notifications">Notifications</a>
                </li>
                                    <ul id="tocify-subheader-notifications" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="notifications-GETapi-v1-customers--customer_id--notifications">
                        <a href="#notifications-GETapi-v1-customers--customer_id--notifications">All Notifications For Customer</a>
                    </li>
                                                    </ul>
                            </ul>
                    <ul id="tocify-header-8" class="tocify-header">
                <li class="tocify-item level-1" data-unique="otp">
                    <a href="#otp">Otp</a>
                </li>
                                    <ul id="tocify-subheader-otp" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="otp-POSTapi-v1-otp-send">
                        <a href="#otp-POSTapi-v1-otp-send">Send Otp</a>
                    </li>
                                                    </ul>
                            </ul>
        
                        
            </div>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
                    </ul>
        <ul class="toc-footer" id="last-updated">
        <li>Last updated: April 20 2022</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>Documentation for Altara customer facing app using open spec api</p>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">https://altara-customer-play-api.herokuapp.com</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="authentication">Authentication</h1>

    <p>API endpoints for managing authentication</p>

            <h2 id="authentication-POSTapi-v1-auth-login">Login</h2>

<p>
</p>

<p>Log customer in using the provided phone number and otp</p>

<span id="example-requests-POSTapi-v1-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://altara-customer-play-api.herokuapp.com/api/v1/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"phone_number\": \"maiores\",
    \"otp\": \"sint\",
    \"device_name\": \"ipsam\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "phone_number": "maiores",
    "otp": "sint",
    "device_name": "ipsam"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-login">
</span>
<span id="execution-results-POSTapi-v1-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-login"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-login"></code></pre>
</span>
<form id="form-POSTapi-v1-auth-login" data-method="POST"
      data-path="api/v1/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-login"
                    onclick="tryItOut('POSTapi-v1-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-login"
                    onclick="cancelTryOut('POSTapi-v1-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-login" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/login</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>phone_number</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone_number"
               data-endpoint="POSTapi-v1-auth-login"
               value="maiores"
               data-component="body" hidden>
    <br>
<p>The customer phone number.</p>
        </p>
                <p>
            <b><code>otp</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="otp"
               data-endpoint="POSTapi-v1-auth-login"
               value="sint"
               data-component="body" hidden>
    <br>
<p>The otp sent to the customer phone number</p>
        </p>
                <p>
            <b><code>device_name</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="device_name"
               data-endpoint="POSTapi-v1-auth-login"
               value="ipsam"
               data-component="body" hidden>
    <br>
<p>The customer device name been used</p>
        </p>
        </form>

            <h2 id="authentication-GETapi-v1-auth-user">Authenticated Customer</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get authenticated user profile</p>

<span id="example-requests-GETapi-v1-auth-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://altara-customer-play-api.herokuapp.com/api/v1/auth/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/auth/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-auth-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: ://localhost:
access-control-allow-credentials: true
access-control-allow-methods: POST, GET, OPTIONS, PUT, DELETE, PATCH
access-control-allow-headers: X-Requested-With, Content-Type, Origin, Authorization
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;data&quot;: [],
    &quot;message&quot;: &quot;Unauthenticated.&quot;,
    &quot;code&quot;: 10
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-auth-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-auth-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-auth-user"></code></pre>
</span>
<span id="execution-error-GETapi-v1-auth-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-auth-user"></code></pre>
</span>
<form id="form-GETapi-v1-auth-user" data-method="GET"
      data-path="api/v1/auth/user"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-auth-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-auth-user"
                    onclick="tryItOut('GETapi-v1-auth-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-auth-user"
                    onclick="cancelTryOut('GETapi-v1-auth-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-auth-user" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/auth/user</code></b>
        </p>
                <p>
            <label id="auth-GETapi-v1-auth-user" hidden>Authorization header:
                <b><code>Bearer </code></b><input type="text"
                                                                name="Authorization"
                                                                data-prefix="Bearer "
                                                                data-endpoint="GETapi-v1-auth-user"
                                                                data-component="header"></label>
        </p>
                </form>

            <h2 id="authentication-GETapi-v1-auth-logout">Logout</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Log customer out of the app</p>

<span id="example-requests-GETapi-v1-auth-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://altara-customer-play-api.herokuapp.com/api/v1/auth/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/auth/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-auth-logout">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: ://localhost:
access-control-allow-credentials: true
access-control-allow-methods: POST, GET, OPTIONS, PUT, DELETE, PATCH
access-control-allow-headers: X-Requested-With, Content-Type, Origin, Authorization
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;data&quot;: [],
    &quot;message&quot;: &quot;Unauthenticated.&quot;,
    &quot;code&quot;: 10
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-auth-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-auth-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-auth-logout"></code></pre>
</span>
<span id="execution-error-GETapi-v1-auth-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-auth-logout"></code></pre>
</span>
<form id="form-GETapi-v1-auth-logout" data-method="GET"
      data-path="api/v1/auth/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-auth-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-auth-logout"
                    onclick="tryItOut('GETapi-v1-auth-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-auth-logout"
                    onclick="cancelTryOut('GETapi-v1-auth-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-auth-logout" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/auth/logout</code></b>
        </p>
                <p>
            <label id="auth-GETapi-v1-auth-logout" hidden>Authorization header:
                <b><code>Bearer </code></b><input type="text"
                                                                name="Authorization"
                                                                data-prefix="Bearer "
                                                                data-endpoint="GETapi-v1-auth-logout"
                                                                data-component="header"></label>
        </p>
                </form>

        <h1 id="customer">Customer</h1>

    <p>Api Endpoints for Customer</p>

            <h2 id="customer-PATCHapi-v1-customers--customer-">Update Profile</h2>

<p>
</p>

<p>This endpoint is used for updating the customer profiles.</p>

<span id="example-requests-PATCHapi-v1-customers--customer-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "https://altara-customer-play-api.herokuapp.com/api/v1/customers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"first_name\": \"John\",
    \"last_name\": \"Doe\",
    \"add_street\": \"48 Ogunaike street, Ikoyi, Lagos State.\",
    \"city\": \"voluptatem\",
    \"state\": \"aut\",
    \"gender\": \"male\",
    \"date_of_birth\": \"ullam\",
    \"employment_status\": \"et\",
    \"civil_status\": \"modi\",
    \"telephone\": \"cumque\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/customers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "John",
    "last_name": "Doe",
    "add_street": "48 Ogunaike street, Ikoyi, Lagos State.",
    "city": "voluptatem",
    "state": "aut",
    "gender": "male",
    "date_of_birth": "ullam",
    "employment_status": "et",
    "civil_status": "modi",
    "telephone": "cumque"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-customers--customer-">
</span>
<span id="execution-results-PATCHapi-v1-customers--customer-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-customers--customer-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-customers--customer-"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-customers--customer-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-customers--customer-"></code></pre>
</span>
<form id="form-PATCHapi-v1-customers--customer-" data-method="PATCH"
      data-path="api/v1/customers/{customer}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-customers--customer-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-customers--customer-"
                    onclick="tryItOut('PATCHapi-v1-customers--customer-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-customers--customer-"
                    onclick="cancelTryOut('PATCHapi-v1-customers--customer-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-customers--customer-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/customers/{customer}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>customer</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="customer"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="1"
               data-component="url" hidden>
    <br>

            </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>first_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="first_name"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="John"
               data-component="body" hidden>
    <br>
<p>The customer first name.</p>
        </p>
                <p>
            <b><code>last_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="last_name"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="Doe"
               data-component="body" hidden>
    <br>
<p>The customer last name.</p>
        </p>
                <p>
            <b><code>add_street</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="add_street"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="48 Ogunaike street, Ikoyi, Lagos State."
               data-component="body" hidden>
    <br>
<p>The customer Address.</p>
        </p>
                <p>
            <b><code>city</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="city"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="voluptatem"
               data-component="body" hidden>
    <br>
<p>The customer city.</p>
        </p>
                <p>
            <b><code>state</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="state"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="aut"
               data-component="body" hidden>
    <br>
<p>The customer state.</p>
        </p>
                <p>
            <b><code>gender</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="gender"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="male"
               data-component="body" hidden>
    <br>
<p>The customer gender</p>
        </p>
                <p>
            <b><code>date_of_birth</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="date_of_birth"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="ullam"
               data-component="body" hidden>
    <br>
<p>The customer date of birth. Example</p>
        </p>
                <p>
            <b><code>employment_status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="employment_status"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="et"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>civil_status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="civil_status"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="modi"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="telephone"
               data-endpoint="PATCHapi-v1-customers--customer-"
               value="cumque"
               data-component="body" hidden>
    <br>
<p>The customer phone number.</p>
        </p>
        </form>

        <h1 id="customer-order">Customer Order</h1>

    

            <h2 id="customer-order-GETapi-v1-customers--customer--orders">All Customer Orders</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint is used for fetching customer orders</p>

<span id="example-requests-GETapi-v1-customers--customer--orders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://altara-customer-play-api.herokuapp.com/api/v1/customers/1/orders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/customers/1/orders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-customers--customer--orders">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: ://localhost:
access-control-allow-credentials: true
access-control-allow-methods: POST, GET, OPTIONS, PUT, DELETE, PATCH
access-control-allow-headers: X-Requested-With, Content-Type, Origin, Authorization
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;data&quot;: [],
    &quot;message&quot;: &quot;Unauthenticated.&quot;,
    &quot;code&quot;: 10
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-customers--customer--orders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-customers--customer--orders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-customers--customer--orders"></code></pre>
</span>
<span id="execution-error-GETapi-v1-customers--customer--orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-customers--customer--orders"></code></pre>
</span>
<form id="form-GETapi-v1-customers--customer--orders" data-method="GET"
      data-path="api/v1/customers/{customer}/orders"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-customers--customer--orders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-customers--customer--orders"
                    onclick="tryItOut('GETapi-v1-customers--customer--orders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-customers--customer--orders"
                    onclick="cancelTryOut('GETapi-v1-customers--customer--orders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-customers--customer--orders" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/customers/{customer}/orders</code></b>
        </p>
                <p>
            <label id="auth-GETapi-v1-customers--customer--orders" hidden>Authorization header:
                <b><code>Bearer </code></b><input type="text"
                                                                name="Authorization"
                                                                data-prefix="Bearer "
                                                                data-endpoint="GETapi-v1-customers--customer--orders"
                                                                data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>customer</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="customer"
               data-endpoint="GETapi-v1-customers--customer--orders"
               value="1"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

            <h2 id="customer-order-POSTapi-v1-submit-request">Apply for Orders</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint is used for applying for orders by customers</p>

<span id="example-requests-POSTapi-v1-submit-request">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://altara-customer-play-api.herokuapp.com/api/v1/submit/request" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"order_type\": \"enim\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/submit/request"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "order_type": "enim"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-submit-request">
</span>
<span id="execution-results-POSTapi-v1-submit-request" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-submit-request"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-submit-request"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-submit-request" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-submit-request"></code></pre>
</span>
<form id="form-POSTapi-v1-submit-request" data-method="POST"
      data-path="api/v1/submit/request"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-submit-request', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-submit-request"
                    onclick="tryItOut('POSTapi-v1-submit-request');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-submit-request"
                    onclick="cancelTryOut('POSTapi-v1-submit-request');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-submit-request" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/submit/request</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-v1-submit-request" hidden>Authorization header:
                <b><code>Bearer </code></b><input type="text"
                                                                name="Authorization"
                                                                data-prefix="Bearer "
                                                                data-endpoint="POSTapi-v1-submit-request"
                                                                data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>order_type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="order_type"
               data-endpoint="POSTapi-v1-submit-request"
               value="enim"
               data-component="body" hidden>
    <br>
<p>The type of product customer is requesting. Example Product or Loan</p>
        </p>
        </form>

        <h1 id="document">Document</h1>

    

            <h2 id="document-POSTapi-v1-document-upload">Upload</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint is used for document upload, available types are passport,id_card,guarantor_id,proof_of_income</p>

<span id="example-requests-POSTapi-v1-document-upload">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://altara-customer-play-api.herokuapp.com/api/v1/document/upload" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "type=passport" \
    --form "document=@/tmp/phpdTX92a" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/document/upload"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('type', 'passport');
body.append('document', document.querySelector('input[name="document"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-document-upload">
</span>
<span id="execution-results-POSTapi-v1-document-upload" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-document-upload"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-document-upload"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-document-upload" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-document-upload"></code></pre>
</span>
<form id="form-POSTapi-v1-document-upload" data-method="POST"
      data-path="api/v1/document/upload"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      data-headers='{"Content-Type":"multipart\/form-data","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-document-upload', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-document-upload"
                    onclick="tryItOut('POSTapi-v1-document-upload');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-document-upload"
                    onclick="cancelTryOut('POSTapi-v1-document-upload');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-document-upload" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/document/upload</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-v1-document-upload" hidden>Authorization header:
                <b><code>Bearer </code></b><input type="text"
                                                                name="Authorization"
                                                                data-prefix="Bearer "
                                                                data-endpoint="POSTapi-v1-document-upload"
                                                                data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>document</code></b>&nbsp;&nbsp;<small>file</small>  &nbsp;
                <input type="file"
               name="document"
               data-endpoint="POSTapi-v1-document-upload"
               value=""
               data-component="body" hidden>
    <br>
<p>The id of the user.</p>
        </p>
                <p>
            <b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="type"
               data-endpoint="POSTapi-v1-document-upload"
               value="passport"
               data-component="body" hidden>
    <br>
<p>The type of document been uploaded.</p>
        </p>
        </form>

        <h1 id="endpoints">Endpoints</h1>

    

            <h2 id="endpoints-GETapi-user">GET api/user</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://altara-customer-play-api.herokuapp.com/api/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: ://localhost:
access-control-allow-credentials: true
access-control-allow-methods: POST, GET, OPTIONS, PUT, DELETE, PATCH
access-control-allow-headers: X-Requested-With, Content-Type, Origin, Authorization
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;data&quot;: [],
    &quot;message&quot;: &quot;Unauthenticated.&quot;,
    &quot;code&quot;: 10
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user"></code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                    </form>

        <h1 id="notifications">Notifications</h1>

    <p>Api Endpoints for Customer Notifications</p>

            <h2 id="notifications-GETapi-v1-customers--customer_id--notifications">All Notifications For Customer</h2>

<p>
</p>

<p>This endpoint is used for getting all customer notifications.</p>

<span id="example-requests-GETapi-v1-customers--customer_id--notifications">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://altara-customer-play-api.herokuapp.com/api/v1/customers/20/notifications" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/customers/20/notifications"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-customers--customer_id--notifications">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: ://localhost:
access-control-allow-credentials: true
access-control-allow-methods: POST, GET, OPTIONS, PUT, DELETE, PATCH
access-control-allow-headers: X-Requested-With, Content-Type, Origin, Authorization
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;data&quot;: [],
    &quot;message&quot;: &quot;Unauthenticated.&quot;,
    &quot;code&quot;: 10
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-customers--customer_id--notifications" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-customers--customer_id--notifications"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-customers--customer_id--notifications"></code></pre>
</span>
<span id="execution-error-GETapi-v1-customers--customer_id--notifications" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-customers--customer_id--notifications"></code></pre>
</span>
<form id="form-GETapi-v1-customers--customer_id--notifications" data-method="GET"
      data-path="api/v1/customers/{customer_id}/notifications"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-customers--customer_id--notifications', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-customers--customer_id--notifications"
                    onclick="tryItOut('GETapi-v1-customers--customer_id--notifications');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-customers--customer_id--notifications"
                    onclick="cancelTryOut('GETapi-v1-customers--customer_id--notifications');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-customers--customer_id--notifications" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/customers/{customer_id}/notifications</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>customer_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="customer_id"
               data-endpoint="GETapi-v1-customers--customer_id--notifications"
               value="20"
               data-component="url" hidden>
    <br>
<p>The ID of the customer.</p>
            </p>
                    </form>

        <h1 id="otp">Otp</h1>

    <p>Api Endpoints for sending otp</p>

            <h2 id="otp-POSTapi-v1-otp-send">Send Otp</h2>

<p>
</p>

<p>Send otp to the provided email address.</p>

<span id="example-requests-POSTapi-v1-otp-send">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://altara-customer-play-api.herokuapp.com/api/v1/otp/send" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"phone_number\": \"quo\",
    \"regenerate\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://altara-customer-play-api.herokuapp.com/api/v1/otp/send"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "phone_number": "quo",
    "regenerate": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-otp-send">
</span>
<span id="execution-results-POSTapi-v1-otp-send" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-otp-send"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-otp-send"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-otp-send" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-otp-send"></code></pre>
</span>
<form id="form-POSTapi-v1-otp-send" data-method="POST"
      data-path="api/v1/otp/send"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-otp-send', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-otp-send"
                    onclick="tryItOut('POSTapi-v1-otp-send');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-otp-send"
                    onclick="cancelTryOut('POSTapi-v1-otp-send');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-otp-send" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/otp/send</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>phone_number</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone_number"
               data-endpoint="POSTapi-v1-otp-send"
               value="quo"
               data-component="body" hidden>
    <br>
<p>The customer phone number.</p>
        </p>
                <p>
            <b><code>regenerate</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-v1-otp-send" hidden>
            <input type="radio" name="regenerate"
                   value="true"
                   data-endpoint="POSTapi-v1-otp-send"
                   data-component="body"
            >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-otp-send" hidden>
            <input type="radio" name="regenerate"
                   value="false"
                   data-endpoint="POSTapi-v1-otp-send"
                   data-component="body"
            >
            <code>false</code>
        </label>
    <br>
<p>Pass this to regenerate otp code for users if previous one has expired</p>
        </p>
        </form>

    

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
