<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:500,600" rel="stylesheet">
    <title>In-App Purchase &#8212; odoo 13.0 documentation</title>
    <link rel="stylesheet" href="../_static/style.css" type="text/css" />
    <link rel="stylesheet" href="../_static/pygments.css" type="text/css" />
    <link rel="stylesheet" href="../_static/patchqueue.css" type="text/css" />
    <script type="text/javascript" src="../_static/documentation_options.js"></script>
    <script type="text/javascript" src="../_static/jquery.js"></script>
    <script type="text/javascript" src="../_static/underscore.js"></script>
    <script type="text/javascript" src="../_static/doctools.js"></script>
    <script type="text/javascript" src="../_static/jquery.min.js"></script>
    <script type="text/javascript" src="../_static/bootstrap.js"></script>
    <script type="text/javascript" src="../_static/doc.js"></script>
    <script type="text/javascript" src="../_static/jquery.noconflict.js"></script>
    <script type="text/javascript" src="../_static/patchqueue.js"></script><link rel="canonical" href="iap.html" />
    <link rel="index" title="Index" href="https://www.odoo.com/documentation/13.0/genindex.html" />
    <link rel="search" title="Search" href="https://www.odoo.com/documentation/13.0/search.html" />
    <link rel="next" title="Database Upgrade" href="upgrade.html" />
    <link rel="prev" title="External API" href="odoo.html" /> 
  </head>
  <body>
    <header>
      <?php
       include('header.php');
      ?>
  </header>
  <div id="wrap" class="">
    <figure class="card top has_banner">
      <span class="card-img" style="background-image: url('../_static/banners/iap.jpg');"></span>
      <div class="container text-center">
        <h1> In-App Purchase </h1>
      </div>
    </figure>
       <main class="container ">    
        <div class="o_content row">
          <aside>
            <div class="navbar-aside text-center">
              <ul class="text-left nav list-group"><li class="list-group-item"><a href="#overview" class="reference ripple internal">Overview</a></li><li class="list-group-item"><a href="#building-your-service" class="reference ripple internal">Building your service</a><ul ><li class="list-group-item"><a href="#register-the-service-on-odoo" class="reference ripple internal">Register the service on Odoo</a></li><li class="list-group-item"><a href="#packs" class="reference ripple internal">Packs</a></li><li class="list-group-item"><a href="#odoo-app" class="reference ripple internal">Odoo App</a></li><li class="list-group-item"><a href="#service" class="reference ripple internal">Service</a></li></ul></li><li class="list-group-item"><a href="#json-rpc2-transaction-api" class="reference ripple internal">JSON-RPC2 Transaction API</a><ul ><li class="list-group-item"><a href="#authorize" class="reference ripple internal">Authorize</a></li><li class="list-group-item"><a href="#capture" class="reference ripple internal">Capture</a></li><li class="list-group-item"><a href="#cancel" class="reference ripple internal">Cancel</a></li><li class="list-group-item"><a href="#types" class="reference ripple internal">Types</a></li><li class="list-group-item"><a href="#test-the-api" class="reference ripple internal">Test the API</a></li></ul></li><li class="list-group-item"><a href="#odoo-helpers" class="reference ripple internal">Odoo Helpers</a><ul ><li class="list-group-item"><a href="#charging" class="reference ripple internal">Charging</a></li><li class="list-group-item"><a href="#id1" class="reference ripple internal">Authorize</a></li><li class="list-group-item"><a href="#id2" class="reference ripple internal">Cancel</a></li><li class="list-group-item"><a href="#id3" class="reference ripple internal">Capture</a></li></ul></li></ul>
              <p class="gith-container"><a href="https://github.com/odoo/odoo/edit/13.0/doc/webservices/iap.rst" class="gith-link">
                  Edit on GitHub
              </a></p>
            </div>
          </aside>
          <article class="doc-body ">
  <section id="in-app-purchase"><p >In-App Purchase (IAP) allows providers of ongoing services through Odoo apps to
be compensated for ongoing service use rather than — and possibly instead of
— a sole initial purchase.</p><p >In that context, Odoo acts mostly as a <em >broker</em> between a client and an Odoo
App Developer:</p><ul ><li >Users purchase service tokens from Odoo.</li><li >Service providers draw tokens from the user’s Odoo account when service
is requested.</li></ul><div role="alert" class="alert alert-warning"><h3 class="alert-title">Attention</h3><p >This document is intended for <em >service providers</em> and presents the latter,
which can be done either via direct <a href="https://www.jsonrpc.org/specification" class="external alert-link reference">JSON-RPC2</a> or if you are using Odoo
using the convenience helpers it provides.</p></div></section><section id="overview"><h2 >Overview</h2><div id="id5"><img src="../_images/players.png" class="img-responsive center-block"><h4 >The Players</h4><ul ><li >The Service Provider is (probably) you the reader, you will be providing
value to the client in the form of a service paid per-use.</li><li >The Client installed your Odoo App, and from there will request services.</li><li >Odoo brokers crediting, the Client adds credit to their account, and you
can draw credits from there to provide services.</li><li >The External Service is an optional player: <em >you</em> can either provide a
service directly, or you can delegate the actual service acting as a
bridge/translator between an Odoo system and the actual service.</li></ul></div><div id="id6"><img src="../_images/credits.jpg" class="img-responsive center-block"><h4 >The Credits</h4></div><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><p >The credits went from integer to float value starting <strong >October 2018</strong>.
Integer values are still supported.</p><p >Every service provided through the IAP platform can be used by the
clients with tokens or <em >credits</em>. The credits are an float unit and
their monetary value depends on the service and is decided by the
provider. This could be:</p><ul ><li >for an sms service: 1 credit = 1 sms;</li><li >for an ad service: 1 credit = 1 ad; or</li><li >for a postage service: 1 credit = 1 post stamp.</li></ul><p >A credit can also simply be associated with a fixed amount of money
to palliate the variations of price (e.g. the prices of sms and stamps
may vary following the countries).</p><p >The value of the credits is fixed with the help of prepaid credit packs
that the clients can buy on <a href="https://iap.odoo.com/" class="external alert-link reference">https://iap.odoo.com</a> (see <a href="#iap-packages" class="alert-link reference internal"><span class="std std-ref">Packs</span></a>).</p></div><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><p >In the following explanations we will ignore the External Service,
they are just a detail of the service you provide.</p></div><div id="id7"><img src="../_images/normal.png" class="img-responsive center-block"><h4 >‘Normal’ service flow</h4><p >If everything goes well, the normal flow is the following:</p><ol ><li >The Client requests a service of some sort.</li><li >The Service Provider asks Odoo if there are enough credits for the
service in the Client’s account, and creates a transaction over that
amount.</li><li >The Service Provider provides the service (either on their own or
calling to External Services).</li><li >The Service Provider goes back to Odoo to capture (if the service could
be provided) or cancel (if the service could not be provided) the
transaction created at step 2.</li><li >Finally, the Service Provider notifies the Client that the service has
been rendered, possibly (depending on the service) displaying or
storing its results in the client’s system.</li></ol></div><div id="id8"><img src="../_images/no-credit.png" class="img-responsive center-block"><h4 >Insufficient credits</h4><p >However, if the Client’s account lacks credits for the service, the flow will be as follows:</p><ol ><li >The Client requests a service as previously.</li><li >The Service Provider asks Odoo if there are enough credits on the
Client’s account and gets a negative reply.</li><li >This is signaled back to the Client.</li><li >Who is redirected to their Odoo account to credit it and re-try.</li></ol></div></section><section id="building-your-service"><h2 >Building your service</h2><p >For this example, the service we will provide is ~~mining dogecoins~~ burning
10 seconds of CPU for a credit. For your own services, you could, for example:</p><ul ><li >provide an online service yourself (e.g. convert quotations to faxes for
business in Japan);</li><li >provide an <em >offline</em> service yourself (e.g. provide accountancy service); or</li><li >act as intermediary to an other service provider (e.g. bridge to an MMS
gateway).</li></ul></section><section id="register-the-service-on-odoo"><i id="register-service"></i><h3 >Register the service on Odoo</h3><p >The first step is to register your service on the IAP endpoint (production
and/or test) before you can actually query user accounts. To create a service,
go to your <em >Portal Account</em> on the IAP endpoint (<a href="https://iap.odoo.com/" class="external reference">https://iap.odoo.com</a> for
production, <a href="https://iap-sandbox.odoo.com/" class="external reference">https://iap-sandbox.odoo.com</a> for testing, the endpoints are
<em >independent</em> and <em >not synchronized</em>). Alternatively, you can go to your portal
on Odoo (<a href="https://iap.odoo.com/my/home" class="external reference">https://iap.odoo.com/my/home</a>) and select <em >In-App Services</em>.</p><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><p >On production, there is a manual validation step before the service
can be used to manage real transactions. This step is automatically passed when
on sandbox to ease the tests.</p></div><p >Log in then go to <span class="menuselection">My Account ‣ Your In-App Services</span>, click
Create and provide the informations of your service.</p><p >The service has <em >seven</em> important fields:</p><ul ><li ><code class="samp">name</code> - <a href="#ServiceName" title="ServiceName" class="reference internal"><code class="py py-class xref">ServiceName</code></a>: This is the string you will need to provide inside
the client’s <a href="#iap-odoo-app" class="reference internal"><span class="std std-ref">app</span></a> when requesting a transaction from Odoo. (e.g.
<code class="py py-class xref">self.env['iap.account].get(name)</code>). As good practice, this should match the
technical name of your app.</li><li ><code class="samp">label</code> - <code class="py py-class xref">Label</code>: The name displayed on the shopping portal for the
client.</li></ul><div role="alert" class="alert alert-warning"><h3 class="alert-title">Warning</h3><p >Both the <a href="#ServiceName" title="ServiceName" class="alert-link reference internal"><code class="py py-class xref">ServiceName</code></a> and <code class="py py-class xref">Label</code> are unique. As good practice, the
<a href="#ServiceName" title="ServiceName" class="alert-link reference internal"><code class="py py-class xref">ServiceName</code></a> should usually match the name of your Odoo Client App.</p></div><ul ><li ><code class="samp">icon</code> - <code class="py py-class xref">Icon</code>: A generic icon that will serve as default for your
<a href="#iap-packages" class="reference internal"><span class="std std-ref">packs</span></a>.</li><li ><code class="samp">key</code> - <a href="#ServiceKey" title="ServiceKey" class="reference internal"><code class="py py-class xref">ServiceKey</code></a>: The developer key that identifies you in
IAP (see <a href="#iap-service" class="reference internal"><span class="std std-ref">your service</span></a>) and allows to draw credits from
the client’s account. It will be shown only once upon creation of the service
and can be regenerated at will.</li></ul><div role="alert" class="alert-danger alert"><h3 class="alert-title">Danger</h3><p >Your <a href="#ServiceKey" title="ServiceKey" class="alert-link reference internal"><code class="py py-class xref">ServiceKey</code></a> <em >is a secret</em>, leaking your service key
allows other application developers to draw credits bought for
your service(s).</p></div><ul ><li ><code class="samp">trial credits</code> - <code class="py py-class xref">Float</code>: This corresponds to the credits you are ready to offer
upon first use to your app users. Note that such service will only be available to clients that
have an active enterprise contract.</li><li ><code class="samp">privacy policy</code> - <code class="py py-class xref">PrivacyPolicy</code>: This is an url to the privacy
policy of your service. This should explicitly mention the <strong >information you collect</strong>,
how you <strong >use it, its relevance</strong> to make your service work and inform the
client on how they can <strong >access, update or delete their personal information</strong>.</li></ul><img src="../_images/menu.png" class="img-responsive center-block"><img src="../_images/service_list.png" class="img-responsive center-block"><img src="../_images/creating_service.png" class="img-responsive center-block"><img src="../_images/service_created.png" class="img-responsive center-block"><p >You can then create <em >credit packs</em> which clients can purchase in order to
use your service.</p></section><section id="packs"><i id="iap-packages"></i><h3 >Packs</h3><p >A credit pack is essentially a product with five characteristics:</p><ul ><li >Name: name of the pack,</li><li >Icon: specific icon for the pack (if not provided, it will fallback on the service icon),</li><li >Description: details on the pack that will appear on the shop page as
well as the invoice,</li><li >Amount: amount of credits the client is entitled to when buying the pack,</li><li >Price: price in EUR (for the time being, USD support is planned).</li></ul><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><p >Odoo takes a 25% commission on all pack sales. Adjust your selling price accordingly.</p></div><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><p >Depending on the strategy, the price per credit may vary from one
pack to another.</p></div><img src="../_images/package.png" class="img-responsive center-block"></section><section id="odoo-app"><i id="iap-odoo-app"></i><h3 >Odoo App</h3><p >The second step is to develop an <a href="https://www.odoo.com/apps" class="external reference">Odoo App</a> which clients can install in their
Odoo instance and through which they can <em >request</em> the services you provide.
Our app will just add a button to the Partners form which lets a user request
burning some CPU time on the server.</p><p >First, we will create an <em >odoo module</em> depending on <code >iap</code>. IAP is a standard
V11 module and the dependency ensures a local account is properly set up and
we will have access to some necessary views and useful helpers.</p><div class="pq-patch"><em >coalroller/__manifest__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="hll"><span class="p">{</span>
</span><span class="hll">    <span class="s1">&#39;name&#39;</span><span class="p">:</span> <span class="s2">&quot;Coal Roller&quot;</span><span class="p">,</span>
</span><span class="hll">    <span class="s1">&#39;category&#39;</span><span class="p">:</span> <span class="s1">&#39;Tools&#39;</span><span class="p">,</span>
</span><span class="hll">    <span class="s1">&#39;depends&#39;</span><span class="p">:</span> <span class="p">[</span><span class="s1">&#39;iap&#39;</span><span class="p">],</span>
</span><span class="hll"><span class="p">}</span>
</span></pre></div>
</div>
</div><em >coalroller/__init__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="hll"><span class="c1"># -*- coding: utf-8 -*-</span>
</span></pre></div>
</div>
</div></div><p >Second, the “local” side of the integration. Here we will only be adding an
action button to the partners view, but you can of course provide significant
local value via your application and additional parts via a remote service.</p><div class="pq-patch"><em >coalroller/__manifest__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span>    <span class="s1">&#39;name&#39;</span><span class="p">:</span> <span class="s2">&quot;Coal Roller&quot;</span><span class="p">,</span>
    <span class="s1">&#39;category&#39;</span><span class="p">:</span> <span class="s1">&#39;Tools&#39;</span><span class="p">,</span>
    <span class="s1">&#39;depends&#39;</span><span class="p">:</span> <span class="p">[</span><span class="s1">&#39;iap&#39;</span><span class="p">],</span>
<span class="hll">    <span class="s1">&#39;data&#39;</span><span class="p">:</span> <span class="p">[</span>
</span><span class="hll">        <span class="s1">&#39;views/views.xml&#39;</span><span class="p">,</span>
</span><span class="hll">    <span class="p">],</span>
</span><span class="p">}</span>
</pre></div>
</div>
</div><em >coalroller/views/views.xml</em><div class="pq-section"><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="hll"><span class="nt">&lt;odoo&gt;</span>
</span><span class="hll">  <span class="nt">&lt;record</span> <span class="na">model=</span><span class="s">&quot;ir.ui.view&quot;</span> <span class="na">id=</span><span class="s">&quot;partner_form_coalroll&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>partner.form.coalroll<span class="nt">&lt;/field&gt;</span>
</span><span class="hll">    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;model&quot;</span><span class="nt">&gt;</span>res.partner<span class="nt">&lt;/field&gt;</span>
</span><span class="hll">    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;inherit_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;base.view_partner_form&quot;</span> <span class="nt">/&gt;</span>
</span><span class="hll">    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;arch&quot;</span> <span class="na">type=</span><span class="s">&quot;xml&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">      <span class="nt">&lt;xpath</span> <span class="na">expr=</span><span class="s">&quot;//div[@name=&#39;button_box&#39;]&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">        <span class="nt">&lt;button</span> <span class="na">type=</span><span class="s">&quot;object&quot;</span> <span class="na">name=</span><span class="s">&quot;action_partner_coalroll&quot;</span>
</span><span class="hll">                <span class="na">class=</span><span class="s">&quot;oe_stat_button&quot;</span> <span class="na">icon=</span><span class="s">&quot;fa-gears&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">          <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">&quot;o_form_field o_stat_info&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">            <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">&quot;o_stat_text&quot;</span><span class="nt">&gt;</span>Roll Coal<span class="nt">&lt;/span&gt;</span>
</span><span class="hll">          <span class="nt">&lt;/div&gt;</span>
</span><span class="hll">        <span class="nt">&lt;/button&gt;</span>
</span><span class="hll">      <span class="nt">&lt;/xpath&gt;</span>
</span><span class="hll">    <span class="nt">&lt;/field&gt;</span>
</span><span class="hll">  <span class="nt">&lt;/record&gt;</span>
</span><span class="hll"><span class="nt">&lt;/odoo&gt;</span>
</span></pre></div>
</div>
</div></div><img src="../_images/button.png" class="img-responsive center-block"><p >We can now implement the action method/callback. This will <em >call our own
server</em>.</p><p >There are no requirements when it comes to the server or the communication
protocol between the app and our server, but <code >iap</code> provides a
<code class="py xref py-func">jsonrpc()</code> helper to call a <a href="https://www.jsonrpc.org/specification" class="external reference">JSON-RPC2</a> endpoint on an
other Odoo instance and transparently re-raise relevant Odoo exceptions
(<a href="#odoo.addons.iap.models.iap.InsufficientCreditError" title="odoo.addons.iap.models.iap.InsufficientCreditError" class="reference internal"><code class="py py-class xref">InsufficientCreditError</code></a>,
<a href="https://www.odoo.com/documentation/13.0/reference/orm.html#odoo.exceptions.AccessError" title="odoo.exceptions.AccessError" class="reference internal"><code class="py py-class xref">odoo.exceptions.AccessError</code></a> and <a href="https://www.odoo.com/documentation/13.0/reference/orm.html#odoo.exceptions.UserError" title="odoo.exceptions.UserError" class="reference internal"><code class="py py-class xref">odoo.exceptions.UserError</code></a>).</p><p >In that call, we will need to provide:</p><ul ><li >any relevant client parameter (none here),</li><li >the <a href="#UserToken" title="UserToken" class="reference internal"><code class="py py-class xref">token</code></a> of the current client that is provided by
the <code >iap.account</code> model’s <code >account_token</code> field. You can retrieve the
account for your service by calling <code class="samp">env['iap.account'].get(<em >service_name</em>)</code>
where <a href="#ServiceName" title="ServiceName" class="reference internal"><code class="py py-class xref">service_name</code></a> is the name of the service registered
on IAP endpoint.</li></ul><div class="pq-patch"><em >coalroller/__init__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="c1"># -*- coding: utf-8 -*-</span>
<span class="hll"><span class="kn">from</span> <span class="nn">.</span> <span class="kn">import</span> <span class="n">models</span>
</span></pre></div>
</div>
</div><em >coalroller/models/__init__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="hll"><span class="kn">from</span> <span class="nn">.</span> <span class="kn">import</span> <span class="n">res_partner</span>
</span></pre></div>
</div>
</div><em >coalroller/models/res_partner.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="hll"><span class="c1"># -*- coding: utf-8 -*-</span>
</span><span class="hll"><span class="kn">from</span> <span class="nn">odoo</span> <span class="kn">import</span> <span class="n">api</span><span class="p">,</span> <span class="n">models</span>
</span><span class="hll"><span class="kn">from</span> <span class="nn">odoo.addons.iap</span> <span class="kn">import</span> <span class="n">jsonrpc</span><span class="p">,</span> <span class="n">InsufficientCreditError</span>
</span><span class="hll">
</span><span class="hll"><span class="c1"># whichever URL you deploy the service at, here we will run the remote</span>
</span><span class="hll"><span class="c1"># service in a local Odoo bound to the port 8070</span>
</span><span class="hll"><span class="n">DEFAULT_ENDPOINT</span> <span class="o">=</span> <span class="s1">&#39;http://localhost:8070&#39;</span>
</span><span class="hll"><span class="k">class</span> <span class="nc">Partner</span><span class="p">(</span><span class="n">models</span><span class="o">.</span><span class="n">Model</span><span class="p">):</span>
</span><span class="hll">    <span class="n">_inherit</span> <span class="o">=</span> <span class="s1">&#39;res.partner&#39;</span>
</span><span class="hll">    <span class="k">def</span> <span class="nf">action_partner_coalroll</span><span class="p">(</span><span class="bp">self</span><span class="p">):</span>
</span><span class="hll">        <span class="c1"># fetch the user&#39;s token for our service</span>
</span><span class="hll">        <span class="n">user_token</span> <span class="o">=</span> <span class="bp">self</span><span class="o">.</span><span class="n">env</span><span class="p">[</span><span class="s1">&#39;iap.account&#39;</span><span class="p">]</span><span class="o">.</span><span class="n">get</span><span class="p">(</span><span class="s1">&#39;coalroller&#39;</span><span class="p">)</span>
</span><span class="hll">        <span class="n">params</span> <span class="o">=</span> <span class="p">{</span>
</span><span class="hll">            <span class="c1"># we don&#39;t have any parameter to provide</span>
</span><span class="hll">            <span class="s1">&#39;account_token&#39;</span><span class="p">:</span> <span class="n">user_token</span><span class="o">.</span><span class="n">account_token</span>
</span><span class="hll">        <span class="p">}</span>
</span><span class="hll">        <span class="c1"># ir.config_parameter allows locally overriding the endpoint</span>
</span><span class="hll">        <span class="c1"># for testing &amp; al</span>
</span><span class="hll">        <span class="n">endpoint</span> <span class="o">=</span> <span class="bp">self</span><span class="o">.</span><span class="n">env</span><span class="p">[</span><span class="s1">&#39;ir.config_parameter&#39;</span><span class="p">]</span><span class="o">.</span><span class="n">sudo</span><span class="p">()</span><span class="o">.</span><span class="n">get_param</span><span class="p">(</span><span class="s1">&#39;coalroller.endpoint&#39;</span><span class="p">,</span> <span class="n">DEFAULT_ENDPOINT</span><span class="p">)</span>
</span><span class="hll">        <span class="n">jsonrpc</span><span class="p">(</span><span class="n">endpoint</span> <span class="o">+</span> <span class="s1">&#39;/roll&#39;</span><span class="p">,</span> <span class="n">params</span><span class="o">=</span><span class="n">params</span><span class="p">)</span>
</span><span class="hll">        <span class="k">return</span> <span class="bp">True</span>
</span></pre></div>
</div>
</div></div><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><p ><code >iap</code> automatically handles
<a href="#odoo.addons.iap.models.iap.InsufficientCreditError" title="odoo.addons.iap.models.iap.InsufficientCreditError" class="alert-link reference internal"><code class="py py-class xref">InsufficientCreditError</code></a> coming from the action
and prompts the user to add credits to their account.</p><p ><code class="py xref py-func">jsonrpc()</code> takes care of re-raising
<a href="#odoo.addons.iap.models.iap.InsufficientCreditError" title="odoo.addons.iap.models.iap.InsufficientCreditError" class="alert-link reference internal"><code class="py py-class xref">InsufficientCreditError</code></a> for you.</p></div><div role="alert" class="alert-danger alert"><h3 class="alert-title">Danger</h3><p >If you are not using <code class="py xref py-func">jsonrpc()</code> you <em >must</em> be
careful to re-raise
<a href="#odoo.addons.iap.models.iap.InsufficientCreditError" title="odoo.addons.iap.models.iap.InsufficientCreditError" class="alert-link reference internal"><code class="py py-class xref">InsufficientCreditError</code></a> in your handler
otherwise the user will not be prompted to credit their account, and the
next call will fail the same way.</p></div></section><section id="service"><i id="iap-service"></i><h3 >Service</h3><p >Though that is not <em >required</em>, since <code >iap</code> provides both a client helper
for <a href="https://www.jsonrpc.org/specification" class="external reference">JSON-RPC2</a> calls (<code class="py xref py-func">jsonrpc()</code>) and a service helper
for transactions (<a href="#odoo.addons.iap.models.iap.charge" title="odoo.addons.iap.models.iap.charge" class="reference internal"><code class="py py-class xref">charge</code></a>) we will also be
implementing the service side as an Odoo module:</p><div class="pq-patch"><em >coalroller_service/__init__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="hll"><span class="c1"># -*- encoding: utf-8 -*-</span>
</span></pre></div>
</div>
</div><em >coalroller_service/__manifest__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="hll"><span class="p">{</span>
</span><span class="hll">    <span class="s1">&#39;name&#39;</span><span class="p">:</span> <span class="s2">&quot;Coal Roller Service&quot;</span><span class="p">,</span>
</span><span class="hll">    <span class="s1">&#39;category&#39;</span><span class="p">:</span> <span class="s1">&#39;Tools&#39;</span><span class="p">,</span>
</span><span class="hll">    <span class="s1">&#39;depends&#39;</span><span class="p">:</span> <span class="p">[</span><span class="s1">&#39;iap&#39;</span><span class="p">],</span>
</span><span class="hll"><span class="p">}</span>
</span></pre></div>
</div>
</div></div><p >Since the query from the client comes as <a href="https://www.jsonrpc.org/specification" class="external reference">JSON-RPC2</a> we will need the
corresponding controller which can call <a href="#odoo.addons.iap.models.iap.charge" title="odoo.addons.iap.models.iap.charge" class="reference internal"><code class="py py-class xref">charge</code></a> and
perform the service within:</p><div class="pq-patch"><em >coalroller_service/controllers/main.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="hll"><span class="kn">import</span> <span class="nn">time</span>
</span><span class="hll">
</span><span class="hll"><span class="kn">from</span> <span class="nn">passlib</span> <span class="kn">import</span> <span class="n">pwd</span><span class="p">,</span> <span class="nb">hash</span>
</span><span class="hll">
</span><span class="hll"><span class="kn">from</span> <span class="nn">odoo</span> <span class="kn">import</span> <span class="n">http</span>
</span><span class="hll"><span class="kn">from</span> <span class="nn">odoo.addons.iap</span> <span class="kn">import</span> <span class="n">charge</span>
</span><span class="hll">
</span><span class="hll"><span class="k">class</span> <span class="nc">CoalBurnerController</span><span class="p">(</span><span class="n">http</span><span class="o">.</span><span class="n">Controller</span><span class="p">):</span>
</span><span class="hll">    <span class="nd">@http.route</span><span class="p">(</span><span class="s1">&#39;/roll&#39;</span><span class="p">,</span> <span class="nb">type</span><span class="o">=</span><span class="s1">&#39;json&#39;</span><span class="p">,</span> <span class="n">auth</span><span class="o">=</span><span class="s1">&#39;none&#39;</span><span class="p">,</span> <span class="n">csrf</span><span class="o">=</span><span class="s1">&#39;false&#39;</span><span class="p">)</span>
</span><span class="hll">    <span class="k">def</span> <span class="nf">roll</span><span class="p">(</span><span class="bp">self</span><span class="p">,</span> <span class="n">account_token</span><span class="p">):</span>
</span><span class="hll">        <span class="c1"># the service key *is a secret*, it should not be committed in</span>
</span><span class="hll">        <span class="c1"># the source</span>
</span><span class="hll">        <span class="n">service_key</span> <span class="o">=</span> <span class="bp">self</span><span class="o">.</span><span class="n">env</span><span class="p">[</span><span class="s1">&#39;ir.config_parameter&#39;</span><span class="p">]</span><span class="o">.</span><span class="n">sudo</span><span class="p">()</span><span class="o">.</span><span class="n">get_param</span><span class="p">(</span><span class="s1">&#39;coalroller.service_key&#39;</span><span class="p">)</span>
</span><span class="hll">
</span><span class="hll">        <span class="c1"># we charge 1 credit for 10 seconds of CPU</span>
</span><span class="hll">        <span class="n">cost</span> <span class="o">=</span> <span class="mi">1</span>
</span><span class="hll">        <span class="c1"># TODO: allow the user to specify how many (tens of seconds) of CPU they want to use</span>
</span><span class="hll">        <span class="k">with</span> <span class="n">charge</span><span class="p">(</span><span class="n">http</span><span class="o">.</span><span class="n">request</span><span class="o">.</span><span class="n">env</span><span class="p">,</span> <span class="n">service_key</span><span class="p">,</span> <span class="n">account_token</span><span class="p">,</span> <span class="n">cost</span><span class="p">):</span>
</span><span class="hll">
</span><span class="hll">            <span class="c1"># 10 seconds of CPU per credit</span>
</span><span class="hll">            <span class="n">end</span> <span class="o">=</span> <span class="n">time</span><span class="o">.</span><span class="n">time</span><span class="p">()</span> <span class="o">+</span> <span class="p">(</span><span class="mi">10</span> <span class="o">*</span> <span class="n">cost</span><span class="p">)</span>
</span><span class="hll">            <span class="k">while</span> <span class="n">time</span><span class="o">.</span><span class="n">time</span><span class="p">()</span> <span class="o">&lt;</span> <span class="n">end</span><span class="p">:</span>
</span><span class="hll">                <span class="c1"># we will use CPU doing useful things: generating and</span>
</span><span class="hll">                <span class="c1"># hashing passphrases</span>
</span><span class="hll">                <span class="n">p</span> <span class="o">=</span> <span class="n">pwd</span><span class="o">.</span><span class="n">genphrase</span><span class="p">()</span>
</span><span class="hll">                <span class="n">h</span> <span class="o">=</span> <span class="nb">hash</span><span class="o">.</span><span class="n">pbkdf2_sha512</span><span class="o">.</span><span class="n">hash</span><span class="p">(</span><span class="n">p</span><span class="p">)</span>
</span><span class="hll">        <span class="c1"># here we don&#39;t have anything useful to the client, an error</span>
</span><span class="hll">        <span class="c1"># will be raised &amp; transmitted in case of issue, if no error</span>
</span><span class="hll">        <span class="c1"># is raised we did the job</span>
</span></pre></div>
</div>
</div><em >coalroller_service/controllers/__init__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="hll"><span class="c1"># -*- encoding: utf-8 -*-</span>
</span><span class="hll"><span class="kn">from</span> <span class="nn">.</span> <span class="kn">import</span> <span class="n">main</span>
</span></pre></div>
</div>
</div><em >coalroller_service/__init__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="c1"># -*- encoding: utf-8 -*-</span>
<span class="hll"><span class="kn">from</span> <span class="nn">.</span> <span class="kn">import</span> <span class="n">controllers</span>
</span></pre></div>
</div>
</div></div><p >The <a href="#odoo.addons.iap.models.iap.charge" title="odoo.addons.iap.models.iap.charge" class="reference internal"><code class="py py-class xref">charge</code></a> helper will:</p><ol ><li >authorize (create) a transaction with the specified number of credits,
if the account does not have enough credits it will raise the relevant
error</li><li >execute the body of the <code >with</code> statement</li><li >if the body of the <code >with</code> executes successfully, update the price
of the transaction if needed</li><li >capture (confirm) the transaction</li><li >otherwise, if an error is raised from the body of the <code >with</code>, cancel the
transaction (and release the hold on the credits)</li></ol><div role="alert" class="alert-danger alert"><h3 class="alert-title">Danger</h3><p >By default, <a href="#odoo.addons.iap.models.iap.charge" title="odoo.addons.iap.models.iap.charge" class="alert-link reference internal"><code class="py py-class xref">charge</code></a> contacts the <em >production</em>
IAP endpoint, <a href="https://iap.odoo.com/" class="external alert-link reference">https://iap.odoo.com</a>. While developing and testing your
service you may want to point it towards the <em >development</em> IAP endpoint
<a href="https://iap-sandbox.odoo.com/" class="external alert-link reference">https://iap-sandbox.odoo.com</a>.</p><p >To do so, set the <code >iap.endpoint</code> config parameter in your service
Odoo: in debug/developer mode, <span class="menuselection">Setting ‣ Technical ‣
Parameters ‣ System Parameters</span>, just define an entry for the key
<code >iap.endpoint</code> if none already exists).</p></div><p >The <a href="#odoo.addons.iap.models.iap.charge" title="odoo.addons.iap.models.iap.charge" class="reference internal"><code class="py py-class xref">charge</code></a> helper has two additional optional
parameters we can use to make things clearer to the end-user.</p><dl ><dt ><code >description</code></dt><dd >is a message which will be associated with the transaction and will be
displayed in the user’s dashboard, it is useful to remind the user why
the charge exists.</dd><dt ><code >credit_template</code></dt><dd >is the name of a <a href="https://www.odoo.com/documentation/13.0/reference/qweb.html#reference-qweb" class="reference internal"><span class="std std-ref">QWeb</span></a> template which will be rendered
and shown to the user if their account has less credit available than the
service provider is requesting, its purpose is to tell your users why
they should be interested in your IAP offers.</dd></dl><div class="pq-patch"><em >coalroller_service/controllers/main.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span>    <span class="k">def</span> <span class="nf">roll</span><span class="p">(</span><span class="bp">self</span><span class="p">,</span> <span class="n">account_token</span><span class="p">):</span>
        <span class="c1"># the service key *is a secret*, it should not be committed in</span>
        <span class="c1"># the source</span>
<span class="hll">        <span class="n">service_key</span> <span class="o">=</span> <span class="n">http</span><span class="o">.</span><span class="n">request</span><span class="o">.</span><span class="n">env</span><span class="p">[</span><span class="s1">&#39;ir.config_parameter&#39;</span><span class="p">]</span><span class="o">.</span><span class="n">sudo</span><span class="p">()</span><span class="o">.</span><span class="n">get_param</span><span class="p">(</span><span class="s1">&#39;coalroller.service_key&#39;</span><span class="p">)</span>
</span>
        <span class="c1"># we charge 1 credit for 10 seconds of CPU</span>
        <span class="n">cost</span> <span class="o">=</span> <span class="mi">1</span>
        <span class="c1"># TODO: allow the user to specify how many (tens of seconds) of CPU they want to use</span>
<span class="hll">        <span class="k">with</span> <span class="n">charge</span><span class="p">(</span><span class="n">http</span><span class="o">.</span><span class="n">request</span><span class="o">.</span><span class="n">env</span><span class="p">,</span> <span class="n">service_key</span><span class="p">,</span> <span class="n">account_token</span><span class="p">,</span> <span class="n">cost</span><span class="p">,</span>
</span><span class="hll">                    <span class="n">description</span><span class="o">=</span><span class="s2">&quot;We&#39;re just obeying orders&quot;</span><span class="p">,</span>
</span><span class="hll">                    <span class="n">credit_template</span><span class="o">=</span><span class="s1">&#39;coalroller_service.no_credit&#39;</span><span class="p">):</span>
</span>
            <span class="c1"># 10 seconds of CPU per credit</span>
            <span class="n">end</span> <span class="o">=</span> <span class="n">time</span><span class="o">.</span><span class="n">time</span><span class="p">()</span> <span class="o">+</span> <span class="p">(</span><span class="mi">10</span> <span class="o">*</span> <span class="n">cost</span><span class="p">)</span>
</pre></div>
</div>
</div><em >coalroller_service/views/no-credit.xml</em><div class="pq-section"><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="hll"><span class="nt">&lt;odoo&gt;</span>
</span><span class="hll">  <span class="nt">&lt;template</span> <span class="na">id=</span><span class="s">&quot;no_credit&quot;</span> <span class="na">name=</span><span class="s">&quot;No credit warning&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">    <span class="nt">&lt;div&gt;</span>
</span><span class="hll">      <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">&quot;container-fluid&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">        <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">&quot;row&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">          <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">&quot;col-md-7 offset-lg-1 mt32 mb32&quot;</span><span class="nt">&gt;</span>
</span><span class="hll">            <span class="nt">&lt;h2&gt;</span>Consume electricity doing nothing useful!<span class="nt">&lt;/h2&gt;</span>
</span><span class="hll">            <span class="nt">&lt;ul&gt;</span>
</span><span class="hll">              <span class="nt">&lt;li&gt;</span>Heat our state of the art data center for no reason<span class="nt">&lt;/li&gt;</span>
</span><span class="hll">              <span class="nt">&lt;li&gt;</span>Use multiple watts for only 0.1€<span class="nt">&lt;/li&gt;</span>
</span><span class="hll">              <span class="nt">&lt;li&gt;</span>Roll coal without going outside<span class="nt">&lt;/li&gt;</span>
</span><span class="hll">            <span class="nt">&lt;/ul&gt;</span>
</span><span class="hll">          <span class="nt">&lt;/div&gt;</span>
</span><span class="hll">        <span class="nt">&lt;/div&gt;</span>
</span><span class="hll">      <span class="nt">&lt;/div&gt;</span>
</span><span class="hll">    <span class="nt">&lt;/div&gt;</span>
</span><span class="hll">  <span class="nt">&lt;/template&gt;</span>
</span><span class="hll"><span class="nt">&lt;/odoo&gt;</span>
</span></pre></div>
</div>
</div><em >coalroller_service/__manifest__.py</em><div class="pq-section"><div class="highlight-python"><div class="highlight"><pre><span></span>    <span class="s1">&#39;name&#39;</span><span class="p">:</span> <span class="s2">&quot;Coal Roller Service&quot;</span><span class="p">,</span>
    <span class="s1">&#39;category&#39;</span><span class="p">:</span> <span class="s1">&#39;Tools&#39;</span><span class="p">,</span>
    <span class="s1">&#39;depends&#39;</span><span class="p">:</span> <span class="p">[</span><span class="s1">&#39;iap&#39;</span><span class="p">],</span>
<span class="hll">    <span class="s1">&#39;data&#39;</span><span class="p">:</span> <span class="p">[</span>
</span><span class="hll">        <span class="s1">&#39;views/no-credit.xml&#39;</span><span class="p">,</span>
</span><span class="hll">    <span class="p">],</span>
</span><span class="p">}</span>
</pre></div>
</div>
</div></div></section><section id="json-rpc2-transaction-api"><h2 ><a href="https://www.jsonrpc.org/specification" class="external reference">JSON-RPC2</a> Transaction API</h2><img src="../_images/flow.png" class="img-responsive center-block"><ul ><li >The IAP transaction API does not require using Odoo when implementing your
server gateway, calls are standard <a href="https://www.jsonrpc.org/specification" class="external reference">JSON-RPC2</a>.</li><li >Calls use different <em >endpoints</em> but the same <em >method</em> on all endpoints
(<code >call</code>).</li><li >Exceptions are returned as <a href="https://www.jsonrpc.org/specification" class="external reference">JSON-RPC2</a> errors, the formal exception name is
available on <code >data.name</code> for programmatic manipulation.</li></ul></section><section id="authorize"><h3 >Authorize</h3><section class="code-function"><h6 ><code>/iap/1/authorize</code></h6><p >Verifies that the user’s account has at least as <code >credit</code> available
<em >and creates a hold (pending transaction) on that amount</em>.</p><p >Any amount currently on hold by a pending transaction is considered
unavailable to further authorize calls.</p><p >Returns a <a href="#TransactionToken" title="TransactionToken" class="alert-link reference internal"><code class="py py-class xref">TransactionToken</code></a> identifying the pending transaction
which can be used to capture (confirm) or cancel said transaction.</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >key</strong> (<a href="#ServiceKey" title="ServiceKey" class="alert-link reference internal"><code >ServiceKey</code></a>) – </li><li ><strong >account_token</strong> (<a href="#UserToken" title="UserToken" class="alert-link reference internal"><code >UserToken</code></a>) – </li><li ><strong >credit</strong> (<a href="https://docs.python.org/3/library/functions.html#float" title="(in Python v3.8)" class="external alert-link reference"><code >float</code></a>) – </li><li ><strong >description</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – optional, helps users identify the reason for
charges on their account</li><li ><strong >dbuuid</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – optional, allows the user to benefit from trial
credits if his database is eligible (see <a href="#register-service" class="alert-link reference internal"><span class="std std-ref">Service registration</span></a>)</li></ul></div></div><div class="code-field"><div class="code-field-name">Returns</div><div class="code-field-body"><a href="#TransactionToken" title="TransactionToken" class="alert-link reference internal"><code class="py py-class xref">TransactionToken</code></a> if the authorization succeeded</div></div><div class="code-field"><div class="code-field-name">Raises</div><div class="code-field-body"><a href="https://www.odoo.com/documentation/13.0/reference/orm.html#odoo.exceptions.AccessError" title="odoo.exceptions.AccessError" class="alert-link reference internal"><code class="py py-class xref">AccessError</code></a> if the service token is invalid</div></div><div class="code-field"><div class="code-field-name">Raises</div><div class="code-field-body"><a href="#odoo.addons.iap.models.iap.InsufficientCreditError" title="odoo.addons.iap.models.iap.InsufficientCreditError" class="alert-link reference internal"><code class="py py-class xref">InsufficientCreditError</code></a> if the account does not have enough credits</div></div><div class="code-field"><div class="code-field-name">Raises</div><div class="code-field-body"><code >TypeError</code> if the <code >credit</code> value is not an integer or a float</div></div></div></section><div class="highlight-python"><div class="highlight"><pre><span></span><span class="n">r</span> <span class="o">=</span> <span class="n">requests</span><span class="o">.</span><span class="n">post</span><span class="p">(</span><span class="n">ODOO</span> <span class="o">+</span> <span class="s1">&#39;/iap/1/authorize&#39;</span><span class="p">,</span> <span class="n">json</span><span class="o">=</span><span class="p">{</span>
    <span class="s1">&#39;jsonrpc&#39;</span><span class="p">:</span> <span class="s1">&#39;2.0&#39;</span><span class="p">,</span>
    <span class="s1">&#39;id&#39;</span><span class="p">:</span> <span class="bp">None</span><span class="p">,</span>
    <span class="s1">&#39;method&#39;</span><span class="p">:</span> <span class="s1">&#39;call&#39;</span><span class="p">,</span>
    <span class="s1">&#39;params&#39;</span><span class="p">:</span> <span class="p">{</span>
        <span class="s1">&#39;account_token&#39;</span><span class="p">:</span> <span class="n">user_account</span><span class="p">,</span>
        <span class="s1">&#39;key&#39;</span><span class="p">:</span> <span class="n">SERVICE_KEY</span><span class="p">,</span>
        <span class="s1">&#39;credit&#39;</span><span class="p">:</span> <span class="mi">25</span><span class="p">,</span>
        <span class="s1">&#39;description&#39;</span><span class="p">:</span> <span class="s2">&quot;Why this is being charged&quot;</span><span class="p">,</span>
    <span class="p">}</span>
<span class="p">})</span><span class="o">.</span><span class="n">json</span><span class="p">()</span>
<span class="k">if</span> <span class="s1">&#39;error&#39;</span> <span class="ow">in</span> <span class="n">r</span><span class="p">:</span>
    <span class="c1"># handle authorize error</span>
<span class="n">tx</span> <span class="o">=</span> <span class="n">r</span><span class="p">[</span><span class="s1">&#39;result&#39;</span><span class="p">]</span>

<span class="c1"># provide your service here</span>
</pre></div>
</div>
</section><section id="capture"><h3 >Capture</h3><section class="code-function"><h6 ><code>/iap/1/capture</code></h6><p >Confirms the specified transaction, transferring the reserved credits from
the user’s account to the service provider’s.</p><p >Capture calls are idempotent: performing capture calls on an already
captured transaction has no further effect.</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >token</strong> (<a href="#TransactionToken" title="TransactionToken" class="alert-link reference internal"><code >TransactionToken</code></a>) – </li><li ><strong >key</strong> (<a href="#ServiceKey" title="ServiceKey" class="alert-link reference internal"><code >ServiceKey</code></a>) – </li><li ><strong >credit_to_capture</strong> (<a href="https://docs.python.org/3/library/functions.html#float" title="(in Python v3.8)" class="external alert-link reference"><code >float</code></a>) – optional parameter to capture a smaller amount of credits than authorized</li></ul></div></div><div class="code-field"><div class="code-field-name">Raises</div><div class="code-field-body"><a href="https://www.odoo.com/documentation/13.0/reference/orm.html#odoo.exceptions.AccessError" title="odoo.exceptions.AccessError" class="alert-link reference internal"><code class="py py-class xref">AccessError</code></a></div></div></div></section><div class="highlight-python"><div class="highlight"><pre><span></span>  <span class="n">r2</span> <span class="o">=</span> <span class="n">requests</span><span class="o">.</span><span class="n">post</span><span class="p">(</span><span class="n">ODOO</span> <span class="o">+</span> <span class="s1">&#39;/iap/1/capture&#39;</span><span class="p">,</span> <span class="n">json</span><span class="o">=</span><span class="p">{</span>
      <span class="s1">&#39;jsonrpc&#39;</span><span class="p">:</span> <span class="s1">&#39;2.0&#39;</span><span class="p">,</span>
      <span class="s1">&#39;id&#39;</span><span class="p">:</span> <span class="bp">None</span><span class="p">,</span>
      <span class="s1">&#39;method&#39;</span><span class="p">:</span> <span class="s1">&#39;call&#39;</span><span class="p">,</span>
      <span class="s1">&#39;params&#39;</span><span class="p">:</span> <span class="p">{</span>
          <span class="s1">&#39;token&#39;</span><span class="p">:</span> <span class="n">tx</span><span class="p">,</span>
          <span class="s1">&#39;key&#39;</span><span class="p">:</span> <span class="n">SERVICE_KEY</span><span class="p">,</span>
<span class="hll">          <span class="s1">&#39;credit_to_capture&#39;</span><span class="p">:</span> <span class="n">credit</span> <span class="ow">or</span> <span class="bp">False</span><span class="p">,</span>
</span>      <span class="p">}</span>
  <span class="p">})</span><span class="o">.</span><span class="n">json</span><span class="p">()</span>
  <span class="k">if</span> <span class="s1">&#39;error&#39;</span> <span class="ow">in</span> <span class="n">r</span><span class="p">:</span>
      <span class="c1"># handle capture error</span>
  <span class="c1"># otherwise transaction is captured</span>
</pre></div>
</div>
</section><section id="cancel"><h3 >Cancel</h3><section class="code-function"><h6 ><code>/iap/1/cancel</code></h6><p >Cancels the specified transaction, releasing the hold on the user’s
credits.</p><p >Cancel calls are idempotent: performing capture calls on an already
cancelled transaction has no further effect.</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >token</strong> (<a href="#TransactionToken" title="TransactionToken" class="alert-link reference internal"><code >TransactionToken</code></a>) – </li><li ><strong >key</strong> (<a href="#ServiceKey" title="ServiceKey" class="alert-link reference internal"><code >ServiceKey</code></a>) – </li></ul></div></div><div class="code-field"><div class="code-field-name">Raises</div><div class="code-field-body"><a href="https://www.odoo.com/documentation/13.0/reference/orm.html#odoo.exceptions.AccessError" title="odoo.exceptions.AccessError" class="alert-link reference internal"><code class="py py-class xref">AccessError</code></a></div></div></div></section><div class="highlight-python"><div class="highlight"><pre><span></span><span class="n">r2</span> <span class="o">=</span> <span class="n">requests</span><span class="o">.</span><span class="n">post</span><span class="p">(</span><span class="n">ODOO</span> <span class="o">+</span> <span class="s1">&#39;/iap/1/cancel&#39;</span><span class="p">,</span> <span class="n">json</span><span class="o">=</span><span class="p">{</span>
    <span class="s1">&#39;jsonrpc&#39;</span><span class="p">:</span> <span class="s1">&#39;2.0&#39;</span><span class="p">,</span>
    <span class="s1">&#39;id&#39;</span><span class="p">:</span> <span class="bp">None</span><span class="p">,</span>
    <span class="s1">&#39;method&#39;</span><span class="p">:</span> <span class="s1">&#39;call&#39;</span><span class="p">,</span>
    <span class="s1">&#39;params&#39;</span><span class="p">:</span> <span class="p">{</span>
        <span class="s1">&#39;token&#39;</span><span class="p">:</span> <span class="n">tx</span><span class="p">,</span>
        <span class="s1">&#39;key&#39;</span><span class="p">:</span> <span class="n">SERVICE_KEY</span><span class="p">,</span>
    <span class="p">}</span>
<span class="p">})</span><span class="o">.</span><span class="n">json</span><span class="p">()</span>
<span class="k">if</span> <span class="s1">&#39;error&#39;</span> <span class="ow">in</span> <span class="n">r</span><span class="p">:</span>
    <span class="c1"># handle cancel error</span>
<span class="c1"># otherwise transaction is cancelled</span>
</pre></div>
</div>
</section><section id="types"><h3 >Types</h3><p >Exceptions aside, these are <em >abstract types</em> used for clarity, you should not
care how they are implemented.</p><section class="code-class"><h6 id="ServiceName"><code><em >class </em>ServiceName</code></h6><p >String identifying your service on <a href="https://iap.odoo.com/" class="external alert-link reference">https://iap.odoo.com</a> (production) as well
as the account related to your service in the client’s database.</p></section><section class="code-class"><h6 id="ServiceKey"><code><em >class </em>ServiceKey</code></h6><p >Identifier generated for the provider’s service. Each key (and service)
matches a token of a fixed value, as generated by the service provide.</p><p >Multiple types of tokens correspond to multiple services. As an exampe, SMS and MMS
could either be the same service (with an MMS being ‘worth’ multiple SMS)
or could be separate services at separate price points.</p><div role="alert" class="alert-danger alert"><h3 class="alert-title">Danger</h3><p >Your service key <em >is a secret</em>, leaking your service key
allows other application developers to draw credits bought for
your service(s).</p></div></section><section class="code-class"><h6 id="UserToken"><code><em >class </em>UserToken</code></h6><p >Identifier for a user account.</p></section><section class="code-class"><h6 id="TransactionToken"><code><em >class </em>TransactionToken</code></h6><p >Transaction identifier, returned by the authorization process and consumed
by either capturing or cancelling the transaction.</p></section><section class="code-exception"><h6 id="odoo.addons.iap.models.iap.InsufficientCreditError"><code><em >exception </em>odoo.addons.iap.models.iap.InsufficientCreditError</code></h6><p >Raised during transaction authorization if the credits requested are not
currently available on the account (either not enough credits or too many
pending transactions/existing holds).</p></section><section class="code-exception"><h6 ><code><em >exception </em>odoo.exceptions.AccessError</code></h6><p >Raised by:</p><ul ><li >any operation to which a service token is required, if the service token is invalid; or</li><li >any failure in an inter-server call. (typically, in <code class="py xref py-func">jsonrpc()</code>).</li></ul></section><section class="code-exception"><h6 ><code><em >exception </em>odoo.exceptions.UserError</code></h6><p >Raised by any unexpected behaviour at the discretion of the App developer (<em >you</em>).</p></section></section><section id="test-the-api"><h3 >Test the API</h3><p >In order to test the developped app, we propose a sandbox platform that allows you to:</p><ol ><li >Test the whole flow from the client’s point of view - Actual services and transactions
that can be consulted. (again this requires to change the endpoint, see the danger note
in <a href="#iap-service" class="reference internal"><span class="std std-ref">Service</span></a>).</li><li >Test the API.</li></ol><p >The latter consists in specific tokens that will work on <strong >IAP-Sandbox only</strong>.</p><ul ><li >Token <code >000000</code>: Represents a non-existing account. Returns
an <a href="#odoo.addons.iap.models.iap.InsufficientCreditError" title="odoo.addons.iap.models.iap.InsufficientCreditError" class="reference internal"><code class="py py-class xref">InsufficientCreditError</code></a> on authorize attempt.</li><li >Token <code >000111</code>: Represents an account without sufficient credits to perform any service.
Returns an <a href="#odoo.addons.iap.models.iap.InsufficientCreditError" title="odoo.addons.iap.models.iap.InsufficientCreditError" class="reference internal"><code class="py py-class xref">InsufficientCreditError</code></a> on authorize attempt.</li><li >Token <code >111111</code>: Represents an account with enough credits to perform any service.
An authorize attempt will return a dummy transacion token that is processed by the capture
and cancel routes.</li></ul><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><ul ><li >Those tokens are only active on the IAP-Sanbox server.</li><li >The service key is completely ignored with this flow, If you want to run a robust test
of your service, you should ignore these tokens.</li></ul></div></section><section id="odoo-helpers"><h2 >Odoo Helpers</h2><p >For convenience, if you are implementing your service using Odoo the <code >iap</code>
module provides a few helpers to make IAP flow even simpler.</p></section><section id="charging"><i id="iap-charging"></i><h3 >Charging</h3><section class="code-class"><h6 id="odoo.addons.iap.models.iap.charge"><code><em >class </em>odoo.addons.iap.models.iap.charge(<em>env</em>, <em>key</em>, <em>account_token</em>, <em>credit</em>[, <em>dbuuid</em>, <em>description</em>, <em>credit_template</em>])</code></h6><p >A <em >context manager</em> for authorizing and automatically capturing or
cancelling transactions for use in the backend/proxy.</p><p >Works much like e.g. a cursor context manager:</p><ul ><li >immediately authorizes a transaction with the specified parameters;</li><li >executes the <code >with</code> body;</li><li >if the body executes in full without error, captures the transaction;</li><li >otherwise cancels it.</li></ul><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >env</strong> (<code >odoo.api.Environment</code>) – used to retrieve the <code >iap.endpoint</code>
configuration key</li><li ><strong >key</strong> (<a href="#ServiceKey" title="ServiceKey" class="alert-link reference internal"><code >ServiceKey</code></a>) – </li><li ><strong >token</strong> (<a href="#UserToken" title="UserToken" class="alert-link reference internal"><code >UserToken</code></a>) – </li><li ><strong >credit</strong> (<a href="https://docs.python.org/3/library/functions.html#float" title="(in Python v3.8)" class="external alert-link reference"><code >float</code></a>) – </li><li ><strong >description</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – </li><li ><strong >template credit_template</strong> (<code >Qweb</code>) – </li></ul></div></div></div></section><div class="highlight-python"><div class="highlight"><pre><span></span>  <span class="nd">@route</span><span class="p">(</span><span class="s1">&#39;/deathstar/superlaser&#39;</span><span class="p">,</span> <span class="nb">type</span><span class="o">=</span><span class="s1">&#39;json&#39;</span><span class="p">)</span>
  <span class="k">def</span> <span class="nf">superlaser</span><span class="p">(</span><span class="bp">self</span><span class="p">,</span> <span class="n">user_account</span><span class="p">,</span>
                 <span class="n">coordinates</span><span class="p">,</span> <span class="n">target</span><span class="p">,</span>
                 <span class="n">factor</span><span class="o">=</span><span class="mf">1.0</span><span class="p">):</span>
      <span class="sd">&quot;&quot;&quot;</span>
<span class="sd">      :param factor: superlaser power factor,</span>
<span class="sd">                     0.0 is none, 1.0 is full power</span>
<span class="sd">      &quot;&quot;&quot;</span>
      <span class="n">credits</span> <span class="o">=</span> <span class="nb">int</span><span class="p">(</span><span class="n">MAXIMUM_POWER</span> <span class="o">*</span> <span class="n">factor</span><span class="p">)</span>
      <span class="n">description</span> <span class="o">=</span> <span class="s2">&quot;We will demonstrate the power of this station on your home planet of Alderaan.&quot;</span>
<span class="hll">      <span class="k">with</span> <span class="n">charge</span><span class="p">(</span><span class="n">request</span><span class="o">.</span><span class="n">env</span><span class="p">,</span> <span class="n">SERVICE_KEY</span><span class="p">,</span> <span class="n">user_account</span><span class="p">,</span> <span class="n">credits</span><span class="p">,</span> <span class="n">description</span><span class="p">)</span> <span class="k">as</span> <span class="n">transaction</span><span class="p">:</span>
</span>          <span class="c1"># TODO: allow other targets</span>
<span class="hll">          <span class="n">transaction</span><span class="o">.</span><span class="n">credit</span> <span class="o">=</span> <span class="nb">max</span><span class="p">(</span><span class="n">credits</span><span class="p">,</span> <span class="mi">2</span><span class="p">)</span>
</span><span class="hll">          <span class="c1"># Sales ongoing one the energy price,</span>
</span><span class="hll">          <span class="c1"># a maximum of 2 credits will be charged/captured.</span>
</span>          <span class="bp">self</span><span class="o">.</span><span class="n">env</span><span class="p">[</span><span class="s1">&#39;systems.planets&#39;</span><span class="p">]</span><span class="o">.</span><span class="n">search</span><span class="p">([</span>
              <span class="p">(</span><span class="s1">&#39;grid&#39;</span><span class="p">,</span> <span class="s1">&#39;=&#39;</span><span class="p">,</span> <span class="s1">&#39;M-10&#39;</span><span class="p">),</span>
              <span class="p">(</span><span class="s1">&#39;name&#39;</span><span class="p">,</span> <span class="s1">&#39;=&#39;</span><span class="p">,</span> <span class="s1">&#39;Alderaan&#39;</span><span class="p">),</span>
          <span class="p">])</span><span class="o">.</span><span class="n">unlink</span><span class="p">()</span>
</pre></div>
</div>
</section><section id="id1"><h3 >Authorize</h3><section class="code-class"><h6 id="odoo.addons.iap.models.iap.authorize"><code><em >class </em>odoo.addons.iap.models.iap.authorize(<em>env</em>, <em>key</em>, <em>account_token</em>, <em>credit</em>[, <em>dbuuid</em>, <em>description</em>, <em>credit_template</em>])</code></h6><p >Will authorize everything.</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >env</strong> (<code >odoo.api.Environment</code>) – used to retrieve the <code >iap.endpoint</code>
configuration key</li><li ><strong >key</strong> (<a href="#ServiceKey" title="ServiceKey" class="alert-link reference internal"><code >ServiceKey</code></a>) – </li><li ><strong >token</strong> (<a href="#UserToken" title="UserToken" class="alert-link reference internal"><code >UserToken</code></a>) – </li><li ><strong >credit</strong> (<a href="https://docs.python.org/3/library/functions.html#float" title="(in Python v3.8)" class="external alert-link reference"><code >float</code></a>) – </li><li ><strong >description</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – </li><li ><strong >template credit_template</strong> (<code >Qweb</code>) – </li></ul></div></div></div></section><div class="highlight-python"><div class="highlight"><pre><span></span>  <span class="nd">@route</span><span class="p">(</span><span class="s1">&#39;/deathstar/superlaser&#39;</span><span class="p">,</span> <span class="nb">type</span><span class="o">=</span><span class="s1">&#39;json&#39;</span><span class="p">)</span>
  <span class="k">def</span> <span class="nf">superlaser</span><span class="p">(</span><span class="bp">self</span><span class="p">,</span> <span class="n">user_account</span><span class="p">,</span>
                 <span class="n">coordinates</span><span class="p">,</span> <span class="n">target</span><span class="p">,</span>
                 <span class="n">factor</span><span class="o">=</span><span class="mf">1.0</span><span class="p">):</span>
      <span class="sd">&quot;&quot;&quot;</span>
<span class="sd">      :param factor: superlaser power factor,</span>
<span class="sd">                     0.0 is none, 1.0 is full power</span>
<span class="sd">      &quot;&quot;&quot;</span>
      <span class="n">credits</span> <span class="o">=</span> <span class="nb">int</span><span class="p">(</span><span class="n">MAXIMUM_POWER</span> <span class="o">*</span> <span class="n">factor</span><span class="p">)</span>
      <span class="n">description</span> <span class="o">=</span> <span class="s2">&quot;We will demonstrate the power of this station on your home planet of Alderaan.&quot;</span>
      <span class="c1">#actual IAP stuff</span>
<span class="hll">      <span class="n">transaction_token</span> <span class="o">=</span> <span class="n">authorize</span><span class="p">(</span><span class="n">request</span><span class="o">.</span><span class="n">env</span><span class="p">,</span> <span class="n">SERVICE_KEY</span><span class="p">,</span> <span class="n">user_account</span><span class="p">,</span> <span class="n">credits</span><span class="p">,</span> <span class="n">description</span><span class="o">=</span><span class="n">description</span><span class="p">)</span>
</span>      <span class="k">try</span><span class="p">:</span>
          <span class="c1"># Beware the power of this laser</span>
          <span class="bp">self</span><span class="o">.</span><span class="n">put_galactical_princess_in_sorrow</span><span class="p">()</span>
      <span class="k">except</span> <span class="ne">Exception</span> <span class="k">as</span> <span class="n">e</span><span class="p">:</span>
          <span class="c1"># Nevermind ...</span>
          <span class="n">r</span> <span class="o">=</span> <span class="n">cancel</span><span class="p">(</span><span class="n">env</span><span class="p">,</span><span class="n">transaction_token</span><span class="p">,</span> <span class="n">key</span><span class="p">)</span>
          <span class="k">raise</span> <span class="n">e</span>
      <span class="k">else</span><span class="p">:</span>
          <span class="c1"># We shall rule over the galaxy!</span>
          <span class="n">capture</span><span class="p">(</span><span class="n">env</span><span class="p">,</span><span class="n">transaction_token</span><span class="p">,</span> <span class="n">key</span><span class="p">,</span> <span class="nb">min</span><span class="p">(</span><span class="n">credits</span><span class="p">,</span> <span class="mi">2</span><span class="p">))</span>
</pre></div>
</div>
</section><section id="id2"><h3 >Cancel</h3><section class="code-class"><h6 id="odoo.addons.iap.models.iap.cancel"><code><em >class </em>odoo.addons.iap.models.iap.cancel(<em>env</em>, <em>transaction_token</em>, <em>key</em>)</code></h6><p >Will cancel an authorized transaction.</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >env</strong> (<code >odoo.api.Environment</code>) – used to retrieve the <code >iap.endpoint</code>
configuration key</li><li ><strong >transaction_token</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – </li><li ><strong >key</strong> (<a href="#ServiceKey" title="ServiceKey" class="alert-link reference internal"><code >ServiceKey</code></a>) – </li></ul></div></div></div></section><div class="highlight-python"><div class="highlight"><pre><span></span>  <span class="nd">@route</span><span class="p">(</span><span class="s1">&#39;/deathstar/superlaser&#39;</span><span class="p">,</span> <span class="nb">type</span><span class="o">=</span><span class="s1">&#39;json&#39;</span><span class="p">)</span>
  <span class="k">def</span> <span class="nf">superlaser</span><span class="p">(</span><span class="bp">self</span><span class="p">,</span> <span class="n">user_account</span><span class="p">,</span>
                 <span class="n">coordinates</span><span class="p">,</span> <span class="n">target</span><span class="p">,</span>
                 <span class="n">factor</span><span class="o">=</span><span class="mf">1.0</span><span class="p">):</span>
      <span class="sd">&quot;&quot;&quot;</span>
<span class="sd">      :param factor: superlaser power factor,</span>
<span class="sd">                     0.0 is none, 1.0 is full power</span>
<span class="sd">      &quot;&quot;&quot;</span>
      <span class="n">credits</span> <span class="o">=</span> <span class="nb">int</span><span class="p">(</span><span class="n">MAXIMUM_POWER</span> <span class="o">*</span> <span class="n">factor</span><span class="p">)</span>
      <span class="n">description</span> <span class="o">=</span> <span class="s2">&quot;We will demonstrate the power of this station on your home planet of Alderaan.&quot;</span>
      <span class="c1">#actual IAP stuff</span>
      <span class="n">transaction_token</span> <span class="o">=</span> <span class="n">authorize</span><span class="p">(</span><span class="n">request</span><span class="o">.</span><span class="n">env</span><span class="p">,</span> <span class="n">SERVICE_KEY</span><span class="p">,</span> <span class="n">user_account</span><span class="p">,</span> <span class="n">credits</span><span class="p">,</span> <span class="n">description</span><span class="o">=</span><span class="n">description</span><span class="p">)</span>
      <span class="k">try</span><span class="p">:</span>
          <span class="c1"># Beware the power of this laser</span>
          <span class="bp">self</span><span class="o">.</span><span class="n">put_galactical_princess_in_sorrow</span><span class="p">()</span>
<span class="hll">      <span class="k">except</span> <span class="ne">Exception</span> <span class="k">as</span> <span class="n">e</span><span class="p">:</span>
</span><span class="hll">          <span class="c1"># Nevermind ...</span>
</span><span class="hll">          <span class="n">r</span> <span class="o">=</span> <span class="n">cancel</span><span class="p">(</span><span class="n">env</span><span class="p">,</span><span class="n">transaction_token</span><span class="p">,</span> <span class="n">key</span><span class="p">)</span>
</span><span class="hll">          <span class="k">raise</span> <span class="n">e</span>
</span>      <span class="k">else</span><span class="p">:</span>
          <span class="c1"># We shall rule over the galaxy!</span>
          <span class="n">capture</span><span class="p">(</span><span class="n">env</span><span class="p">,</span><span class="n">transaction_token</span><span class="p">,</span> <span class="n">key</span><span class="p">,</span> <span class="nb">min</span><span class="p">(</span><span class="n">credits</span><span class="p">,</span> <span class="mi">2</span><span class="p">))</span>
</pre></div>
</div>
</section><section id="id3"><h3 >Capture</h3><section class="code-class"><h6 id="odoo.addons.iap.models.iap.capture"><code><em >class </em>odoo.addons.iap.models.iap.capture(<em>env</em>, <em>transaction_token</em>, <em>key</em>, <em>credit</em>)</code></h6><p >Will capture the amount <code >credit</code> on the given transaction.</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >env</strong> (<code >odoo.api.Environment</code>) – used to retrieve the <code >iap.endpoint</code>
configuration key</li><li ><strong >transaction_token</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – </li><li ><strong >key</strong> (<a href="#ServiceKey" title="ServiceKey" class="alert-link reference internal"><code >ServiceKey</code></a>) – </li><li ><strong >credit</strong> – </li></ul></div></div></div></section><div class="highlight-python"><div class="highlight"><pre><span></span>  <span class="nd">@route</span><span class="p">(</span><span class="s1">&#39;/deathstar/superlaser&#39;</span><span class="p">,</span> <span class="nb">type</span><span class="o">=</span><span class="s1">&#39;json&#39;</span><span class="p">)</span>
  <span class="k">def</span> <span class="nf">superlaser</span><span class="p">(</span><span class="bp">self</span><span class="p">,</span> <span class="n">user_account</span><span class="p">,</span>
                 <span class="n">coordinates</span><span class="p">,</span> <span class="n">target</span><span class="p">,</span>
                 <span class="n">factor</span><span class="o">=</span><span class="mf">1.0</span><span class="p">):</span>
      <span class="sd">&quot;&quot;&quot;</span>
<span class="sd">      :param factor: superlaser power factor,</span>
<span class="sd">                     0.0 is none, 1.0 is full power</span>
<span class="sd">      &quot;&quot;&quot;</span>
      <span class="n">credits</span> <span class="o">=</span> <span class="nb">int</span><span class="p">(</span><span class="n">MAXIMUM_POWER</span> <span class="o">*</span> <span class="n">factor</span><span class="p">)</span>
      <span class="n">description</span> <span class="o">=</span> <span class="s2">&quot;We will demonstrate the power of this station on your home planet of Alderaan.&quot;</span>
      <span class="c1">#actual IAP stuff</span>
      <span class="n">transaction_token</span> <span class="o">=</span> <span class="n">authorize</span><span class="p">(</span><span class="n">request</span><span class="o">.</span><span class="n">env</span><span class="p">,</span> <span class="n">SERVICE_KEY</span><span class="p">,</span> <span class="n">user_account</span><span class="p">,</span> <span class="n">credits</span><span class="p">,</span> <span class="n">description</span><span class="o">=</span><span class="n">description</span><span class="p">)</span>
      <span class="k">try</span><span class="p">:</span>
          <span class="c1"># Beware the power of this laser</span>
          <span class="bp">self</span><span class="o">.</span><span class="n">put_galactical_princess_in_sorrow</span><span class="p">()</span>
      <span class="k">except</span> <span class="ne">Exception</span> <span class="k">as</span> <span class="n">e</span><span class="p">:</span>
          <span class="c1"># Nevermind ...</span>
          <span class="n">r</span> <span class="o">=</span> <span class="n">cancel</span><span class="p">(</span><span class="n">env</span><span class="p">,</span><span class="n">transaction_token</span><span class="p">,</span> <span class="n">key</span><span class="p">)</span>
          <span class="k">raise</span> <span class="n">e</span>
<span class="hll">      <span class="k">else</span><span class="p">:</span>
</span><span class="hll">          <span class="c1"># We shall rule over the galaxy!</span>
</span><span class="hll">          <span class="n">capture</span><span class="p">(</span><span class="n">env</span><span class="p">,</span><span class="n">transaction_token</span><span class="p">,</span> <span class="n">key</span><span class="p">,</span> <span class="nb">min</span><span class="p">(</span><span class="n">credits</span><span class="p">,</span> <span class="mi">2</span><span class="p">))</span>
</span></pre></div>
</div>
</section>
          </article>
        </div>
        <div id="mask"></div>
      </main>
  </div>
  <div class="floating_action_container">
    <a id="floating_action" class="ripple" href="#">
      <i class="mdi-action-explore"></i>
    </a>
    <div id="floating_action_menu">
      <span class="bubble"></span>
      <ul class="list-group content">
        <li class="list-group-item ripple"><a>Cras justo odio</a></li>
        <li class="list-group-item ripple"><a>Dapibus ac facilisis in</a></li>
        <li class="list-group-item ripple"><a>Morbi leo risus</a></li>
        <li class="list-group-item ripple"><a>Porta ac consectetur ac</a></li>
        <li class="list-group-item ripple"><a>Vestibulum at eros</a></li>
      </ul>
    </div>
  </div>
  <footer>
    <?php
       include('footer.php');
    ?>    
  </footer><script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-52174891-1', 'auto');
    ga('send','pageview');
    </script>
  </body>
</html>