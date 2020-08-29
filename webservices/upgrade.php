<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:500,600" rel="stylesheet">
  
    <title>Database Upgrade &#8212; odoo 13.0 documentation</title>
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
    <script type="text/javascript" src="../_static/patchqueue.js"></script><link rel="canonical" href="upgrade.html" />
  
    <link rel="index" title="Index" href="https://www.odoo.com/documentation/13.0/genindex.html" />
    <link rel="search" title="Search" href="https://www.odoo.com/documentation/13.0/search.html" />
    <link rel="next" title="Creating a Localization" href="localization.html" />
    <link rel="prev" title="In-App Purchase" href="iap.html" /> 
  </head><body>
    <header>
      <?php
       include('header.php');
      ?>
  </header><div id="wrap" class="has_code_col">
    <figure class="card top has_banner">
      <span class="card-img" style="background-image: url('../_static/banners/upgrade_api.jpg');"></span>
      <div class="container text-center">
        <h1> Database Upgrade </h1>
      </div>
    </figure>
      <main class="container has_code_col">
        <div class="o_content row">
          <aside>
            <div class="navbar-aside text-center">
              <ul class="text-left nav list-group"><li class="list-group-item"><a href="#introduction" class="reference ripple internal">Introduction</a></li><li class="list-group-item"><a href="#the-methods" class="reference ripple internal">The methods</a><ul ><li class="list-group-item"><a href="#creating-a-database-upgrade-request" class="reference ripple internal">Creating a database upgrade request</a><ul ><li class="list-group-item"><a href="#the-create-method" class="reference ripple internal">The <code >create</code> method</a><ul ><li class="list-group-item"><a href="#failures" class="reference ripple internal"><code >failures</code></a></li><li class="list-group-item"><a href="#request" class="reference ripple internal"><code >request</code></a></li><li class="list-group-item"><a href="#sample-script" class="reference ripple internal">Sample script</a></li></ul></li></ul></li><li class="list-group-item"><a href="#uploading-your-database-dump" class="reference ripple internal">Uploading your database dump</a><ul ><li class="list-group-item"><a href="#the-upload-method" class="reference ripple internal">The <code >upload</code> method</a></li><li class="list-group-item"><a href="#the-request-sftp-access-method" class="reference ripple internal">The <code >request_sftp_access</code> method</a><ul ><li class="list-group-item"><a href="#id1" class="reference ripple internal"><code >failures</code></a></li><li class="list-group-item"><a href="#id2" class="reference ripple internal"><code >request</code></a><ul ><li class="list-group-item"><a href="#using-the-sftp-client" class="reference ripple internal">Using the ‘sftp’ client</a></li></ul></li></ul></li></ul></li><li class="list-group-item"><a href="#asking-to-process-your-request" class="reference ripple internal">Asking to process your request</a><ul ><li class="list-group-item"><a href="#the-process-method" class="reference ripple internal">The <code >process</code> method</a></li></ul></li><li class="list-group-item"><a href="#asking-to-skip-the-tests" class="reference ripple internal">Asking to skip the tests</a><ul ><li class="list-group-item"><a href="#the-skip-test-method" class="reference ripple internal">The <code >skip_test</code> method</a></li></ul></li><li class="list-group-item"><a href="#obtaining-your-request-status" class="reference ripple internal">Obtaining your request status</a><ul ><li class="list-group-item"><a href="#the-status-method" class="reference ripple internal">The <code >status</code> method</a></li><li class="list-group-item"><a href="#sample-output" class="reference ripple internal">Sample output</a></li></ul></li><li class="list-group-item"><a href="#downloading-your-database-dump" class="reference ripple internal">Downloading your database dump</a></li></ul></li></ul>
              <p class="gith-container"><a href="https://github.com/odoo/odoo/edit/13.0/doc/webservices/upgrade.rst" class="gith-link">
                  Edit on GitHub
              </a></p>
            </div>
          </aside>
          <article class="doc-body ">  
  <section id="database-upgrade"><i id="reference-upgrade-api"></i></section><section id="introduction"><h2 >Introduction</h2><p >This document describes the API used to upgrade an Odoo database to a
higher version.</p><p >It allows a database to be upgraded without ressorting to the html form at
<a href="https://upgrade.odoo.com/" class="external reference">https://upgrade.odoo.com</a>
Although the database will follow the same process described on that form.</p><p >The required steps are:</p><ul ><li ><a href="#upgrade-api-create-method" class="reference internal"><span class="std std-ref">creating a request</span></a></li><li ><a href="#upgrade-api-upload-method" class="reference internal"><span class="std std-ref">uploading a database dump</span></a></li><li ><a href="#upgrade-api-process-method" class="reference internal"><span class="std std-ref">running the upgrade process</span></a></li><li ><a href="#upgrade-api-status-method" class="reference internal"><span class="std std-ref">obtaining the status of the database request</span></a></li><li ><a href="#upgrade-api-download-method" class="reference internal"><span class="std std-ref">downloading the upgraded database dump</span></a></li></ul></section><section id="the-methods"><h2 >The methods</h2></section><section id="creating-a-database-upgrade-request"><i id="upgrade-api-create-method"></i><h3 >Creating a database upgrade request</h3><p >This action creates a database request with the following information:</p><ul ><li >your contract reference</li><li >your email address</li><li >the target version (the Odoo version you want to upgrade to)</li><li >the purpose of your request (test or production)</li><li >the database dump name (required but purely informative)</li><li >optionally the server timezone (for Odoo source version &lt; 6.1)</li></ul></section><section id="the-create-method"><h4 >The <code >create</code> method</h4><section class="code-function"><h6 ><code>https://upgrade.odoo.com/database/v1/create</code></h6><p >Creates a database upgrade request</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >contract</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your enterprise contract reference</li><li ><strong >email</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your email address</li><li ><strong >target</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) the Odoo version you want to upgrade to. Valid choices: 11.0, 12.0, 13.0</li><li ><strong >aim</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) the purpose of your upgrade database request. Valid choices: test, production.</li><li ><strong >filename</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) a purely informative name for you database dump file</li><li ><strong >timezone</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (optional) the timezone used by your server. Only for Odoo source version &lt; 6.1</li></ul></div></div><div class="code-field"><div class="code-field-name">Returns</div><div class="code-field-body">request result</div></div><div class="code-field"><div class="code-field-name">Return type</div><div class="code-field-body">JSON dictionary</div></div></div></section><p >The <em >create</em> method returns a JSON dictionary containing the following keys:</p></section><section id="failures"><i id="upgrade-api-json-failure"></i><h5 ><code >failures</code></h5><p >The list of errors.</p><p >A list of dictionaries, each dictionary giving information about one particular
error. Each dictionary can contain various keys depending of the type of error
but you will always get the <code >reason</code> and the <code >message</code> keys:</p><ul ><li ><code >reason</code>: the error type</li><li ><code >message</code>: a human friendly message</li></ul><p >Some possible keys:</p><ul ><li ><code >code</code>: a faulty value</li><li ><code >value</code>: a faulty value</li><li ><code >expected</code>: a list of valid values</li></ul><p >See a sample output aside.</p><div class="content-switcher setup doc-aside"><ul ><li >JSON</li></ul><div class="tabs"><div class="highlight-json"><div class="highlight"><pre><span></span><span class="p">{</span>
  <span class="nt">&quot;failures&quot;</span><span class="p">:</span> <span class="p">[</span>
    <span class="p">{</span>
      <span class="nt">&quot;expected&quot;</span><span class="p">:</span> <span class="p">[</span>
        <span class="s2">&quot;11.0&quot;</span><span class="p">,</span>
        <span class="s2">&quot;12.0&quot;</span><span class="p">,</span>
        <span class="s2">&quot;13.0&quot;</span><span class="p">,</span>
      <span class="p">],</span>
      <span class="nt">&quot;message&quot;</span><span class="p">:</span> <span class="s2">&quot;Invalid value \&quot;5.0\&quot;&quot;</span><span class="p">,</span>
      <span class="nt">&quot;reason&quot;</span><span class="p">:</span> <span class="s2">&quot;TARGET:INVALID&quot;</span><span class="p">,</span>
      <span class="nt">&quot;value&quot;</span><span class="p">:</span> <span class="s2">&quot;5.0&quot;</span>
    <span class="p">},</span>
    <span class="p">{</span>
      <span class="nt">&quot;code&quot;</span><span class="p">:</span> <span class="s2">&quot;M123456-abcxyz&quot;</span><span class="p">,</span>
      <span class="nt">&quot;message&quot;</span><span class="p">:</span> <span class="s2">&quot;Can not find contract M123456-abcxyz&quot;</span><span class="p">,</span>
      <span class="nt">&quot;reason&quot;</span><span class="p">:</span> <span class="s2">&quot;CONTRACT:NOT_FOUND&quot;</span>
    <span class="p">}</span>
  <span class="p">]</span>
<span class="p">}</span>
</pre></div>
</div>
</div></div></section><section id="request"><h5 ><code >request</code></h5><p >If the <em >create</em> method is successful, the value associated to the <em >request</em> key
will be a dictionary containing various information about the created request:</p><p >The most important keys are:</p><ul ><li ><code >id</code>: the request id</li><li ><code >key</code>: your private key for this request</li></ul><p >These 2 values will be requested by the other methods (upload, process and status)</p><p >The other keys will be explained in the section describing the <a href="#upgrade-api-status-method" class="reference internal"><span class="std std-ref">status method</span></a>.</p></section><section id="sample-script"><h5 >Sample script</h5><p >Here are 2 examples of database upgrade request creation using:</p><ul ><li >one in the python programming language using the requests library</li><li >one in the bash programming language using <a href="https://curl.haxx.se/" class="external reference">curl</a> (tool
for transfering data using http) and <a href="https://stedolan.github.io/jq" class="external reference">jq</a> (JSON processor):</li></ul><div class="content-switcher setup doc-aside"><ul ><li >Python 2</li><li >Bash</li></ul><div class="tabs"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="kn">import</span> <span class="nn">requests</span>

<span class="n">CREATE_URL</span> <span class="o">=</span> <span class="s2">&quot;https://upgrade.odoo.com/database/v1/create&quot;</span>
<span class="n">CONTRACT</span> <span class="o">=</span> <span class="s2">&quot;M123456-abcdef&quot;</span>
<span class="n">AIM</span> <span class="o">=</span> <span class="s2">&quot;test&quot;</span>
<span class="n">TARGET</span> <span class="o">=</span> <span class="s2">&quot;12.0&quot;</span>
<span class="n">EMAIL</span> <span class="o">=</span> <span class="s2">&quot;john.doe@example.com&quot;</span>
<span class="n">FILENAME</span> <span class="o">=</span> <span class="s2">&quot;db_name.dump&quot;</span>

<span class="n">fields</span> <span class="o">=</span> <span class="nb">dict</span><span class="p">([</span>
    <span class="p">(</span><span class="s1">&#39;aim&#39;</span><span class="p">,</span> <span class="n">AIM</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;email&#39;</span><span class="p">,</span> <span class="n">EMAIL</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;filename&#39;</span><span class="p">,</span> <span class="n">DB_SOURCE</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;contract&#39;</span><span class="p">,</span> <span class="n">CONTRACT</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;target&#39;</span><span class="p">,</span> <span class="n">TARGET</span><span class="p">),</span>
<span class="p">])</span>

<span class="n">r</span> <span class="o">=</span> <span class="n">requests</span><span class="o">.</span><span class="n">get</span><span class="p">(</span><span class="n">CREATE_URL</span><span class="p">,</span> <span class="n">data</span><span class="o">=</span><span class="n">fields</span><span class="p">)</span>
<span class="k">print</span><span class="p">(</span><span class="n">r</span><span class="o">.</span><span class="n">text</span><span class="p">)</span>
</pre></div>
</div>
<div class="highlight-bash"><div class="highlight"><pre><span></span><span class="nv">CONTRACT</span><span class="o">=</span>M123456-abcdef
<span class="nv">AIM</span><span class="o">=</span><span class="nb">test</span>
<span class="nv">TARGET</span><span class="o">=</span><span class="m">12</span>.0
<span class="nv">EMAIL</span><span class="o">=</span>john.doe@example.com
<span class="nv">FILENAME</span><span class="o">=</span>db_name.dump
<span class="nv">CREATE_URL</span><span class="o">=</span><span class="s2">&quot;https://upgrade.odoo.com/database/v1/create&quot;</span>
<span class="nv">URL_PARAMS</span><span class="o">=</span><span class="s2">&quot;contract=</span><span class="si">${</span><span class="nv">CONTRACT</span><span class="si">}</span><span class="s2">&amp;aim=</span><span class="si">${</span><span class="nv">AIM</span><span class="si">}</span><span class="s2">&amp;target=</span><span class="si">${</span><span class="nv">TARGET</span><span class="si">}</span><span class="s2">&amp;email=</span><span class="si">${</span><span class="nv">EMAIL</span><span class="si">}</span><span class="s2">&amp;filename=</span><span class="si">${</span><span class="nv">FILENAME</span><span class="si">}</span><span class="s2">&quot;</span>
curl -sS <span class="s2">&quot;</span><span class="si">${</span><span class="nv">CREATE_URL</span><span class="si">}</span><span class="s2">?</span><span class="si">${</span><span class="nv">URL_PARAMS</span><span class="si">}</span><span class="s2">&quot;</span> &gt; create_result.json

<span class="c1"># check for failures</span>
<span class="nv">failures</span><span class="o">=</span><span class="k">$(</span>cat create_result.json <span class="p">|</span> jq -r <span class="s1">&#39;.failures[]&#39;</span><span class="k">)</span>
<span class="k">if</span> <span class="o">[</span> <span class="s2">&quot;</span><span class="nv">$failures</span><span class="s2">&quot;</span> !<span class="o">=</span> <span class="s2">&quot;&quot;</span> <span class="o">]</span><span class="p">;</span> <span class="k">then</span>
  <span class="nb">echo</span> <span class="nv">$failures</span> <span class="p">|</span> jq -r <span class="s1">&#39;.&#39;</span>
  <span class="nb">exit</span> <span class="m">1</span>
<span class="k">fi</span>
</pre></div>
</div>
</div></div></section><section id="uploading-your-database-dump"><i id="upgrade-api-upload-method"></i><h3 >Uploading your database dump</h3><p >There are 2 methods to upload your database dump:</p><ul ><li >the <code >upload</code> method using the HTTPS protocol</li><li >the <code >request_sftp_access</code> method using the SFTP protocol</li></ul></section><section id="the-upload-method"><h4 >The <code >upload</code> method</h4><p >It’s the most simple and most straightforward way of uploading your database dump.
It uses the HTTPS protocol.</p><section class="code-function"><h6 ><code>https://upgrade.odoo.com/database/v1/upload</code></h6><p >Uploads a database dump</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >key</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your private key</li><li ><strong >request</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your request id</li></ul></div></div><div class="code-field"><div class="code-field-name">Returns</div><div class="code-field-body">request result</div></div><div class="code-field"><div class="code-field-name">Return type</div><div class="code-field-body">JSON dictionary</div></div></div></section><p >The request id and the private key are obtained using the <a href="#upgrade-api-create-method" class="reference internal"><span class="std std-ref">create method</span></a></p><p >The result is a JSON dictionary containing the list of <code >failures</code>, which
should be empty if everything went fine.</p><div class="content-switcher setup doc-aside"><ul ><li >Python 2</li><li >Bash</li></ul><div class="tabs"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="kn">import</span> <span class="nn">requests</span>

<span class="n">UPLOAD_URL</span> <span class="o">=</span> <span class="s2">&quot;https://upgrade.odoo.com/database/v1/upload&quot;</span>
<span class="n">DUMPFILE</span> <span class="o">=</span> <span class="s2">&quot;/tmp/dump.sql&quot;</span>

<span class="n">fields</span> <span class="o">=</span> <span class="nb">dict</span><span class="p">([</span>
    <span class="p">(</span><span class="s1">&#39;request&#39;</span><span class="p">,</span> <span class="s1">&#39;10534&#39;</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;key&#39;</span><span class="p">,</span> <span class="s1">&#39;Aw7pItGVKFuZ_FOR3U8VFQ==&#39;</span><span class="p">),</span>
<span class="p">])</span>
<span class="n">headers</span> <span class="o">=</span> <span class="p">{</span><span class="s2">&quot;Content-Type&quot;</span><span class="p">:</span> <span class="s2">&quot;application/octet-stream&quot;</span><span class="p">}</span>

<span class="k">with</span> <span class="nb">open</span><span class="p">(</span><span class="n">DUMPFILE</span><span class="p">,</span> <span class="s1">&#39;rb&#39;</span><span class="p">)</span> <span class="k">as</span> <span class="n">f</span><span class="p">:</span>
    <span class="n">requests</span><span class="o">.</span><span class="n">post</span><span class="p">(</span><span class="n">UPLOAD_URL</span><span class="p">,</span> <span class="n">data</span><span class="o">=</span><span class="n">f</span><span class="p">,</span> <span class="n">params</span><span class="o">=</span><span class="n">fields</span><span class="p">,</span> <span class="n">headers</span><span class="o">=</span><span class="n">headers</span><span class="p">)</span>
</pre></div>
</div>
<div class="highlight-bash"><div class="highlight"><pre><span></span><span class="nv">UPLOAD_URL</span><span class="o">=</span><span class="s2">&quot;https://upgrade.odoo.com/database/v1/upload&quot;</span>
<span class="nv">DUMPFILE</span><span class="o">=</span><span class="s2">&quot;openchs.70.cdump&quot;</span>
<span class="nv">KEY</span><span class="o">=</span><span class="s2">&quot;Aw7pItGVKFuZ_FOR3U8VFQ==&quot;</span>
<span class="nv">REQUEST_ID</span><span class="o">=</span><span class="s2">&quot;10534&quot;</span>
<span class="nv">URL_PARAMS</span><span class="o">=</span><span class="s2">&quot;key=</span><span class="si">${</span><span class="nv">KEY</span><span class="si">}</span><span class="s2">&amp;request=</span><span class="si">${</span><span class="nv">REQUEST_ID</span><span class="si">}</span><span class="s2">&quot;</span>
<span class="nv">HEADER</span><span class="o">=</span><span class="s2">&quot;Content-Type: application/octet-stream&quot;</span>
curl -H <span class="nv">$HEADER</span> --data-binary <span class="s2">&quot;@</span><span class="si">${</span><span class="nv">DUMPFILE</span><span class="si">}</span><span class="s2">&quot;</span> <span class="s2">&quot;</span><span class="si">${</span><span class="nv">UPLOAD_URL</span><span class="si">}</span><span class="s2">?</span><span class="si">${</span><span class="nv">URL_PARAMS</span><span class="si">}</span><span class="s2">&quot;</span>
</pre></div>
</div>
</div></div></section><section id="the-request-sftp-access-method"><i id="upgrade-api-request-sftp-access-method"></i><h4 >The <code >request_sftp_access</code> method</h4><p >This method is recommanded for big database dumps.
It uses the SFTP protocol and supports resuming.</p><p >It will create a temporary SFTP server where you can connect to and allow you
to upload your database dump using an SFTP client.</p><section class="code-function"><h6 ><code>https://upgrade.odoo.com/database/v1/request_sftp_access</code></h6><p >Creates an SFTP server</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >key</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your private key</li><li ><strong >request</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your request id</li><li ><strong >ssh_keys</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) the path to a file listing the ssh public keys you’d like to use</li></ul></div></div><div class="code-field"><div class="code-field-name">Returns</div><div class="code-field-body">request result</div></div><div class="code-field"><div class="code-field-name">Return type</div><div class="code-field-body">JSON dictionary</div></div></div></section><p >The request id and the private key are obtained using the <a href="#upgrade-api-create-method" class="reference internal"><span class="std std-ref">create method</span></a></p><p >The file listing your ssh public keys should be roughly similar to a standard <code >authorized_keys</code> file.
This file should only contains public keys, blank lines or comments (lines starting with the <code >#</code> character)</p><p >Your database upgrade request should be in the <code >draft</code> state.</p><p >The <code >request_sftp_access</code> method returns a JSON dictionary containing the following keys:</p><div class="content-switcher setup doc-aside"><ul ><li >Python 2</li><li >Bash</li></ul><div class="tabs"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="kn">import</span> <span class="nn">requests</span>

<span class="n">UPLOAD_URL</span> <span class="o">=</span> <span class="s2">&quot;https://upgrade.odoo.com/database/v1/request_sftp_access&quot;</span>
<span class="n">SSH_KEY</span> <span class="o">=</span> <span class="s2">&quot;$HOME/.ssh/id_rsa.pub&quot;</span>
<span class="n">SSH_KEY_CONTENT</span> <span class="o">=</span> <span class="nb">open</span><span class="p">(</span><span class="n">SSH_KEY</span><span class="p">,</span><span class="s1">&#39;r&#39;</span><span class="p">)</span><span class="o">.</span><span class="n">read</span><span class="p">()</span>

<span class="n">fields</span> <span class="o">=</span> <span class="nb">dict</span><span class="p">([</span>
    <span class="p">(</span><span class="s1">&#39;request&#39;</span><span class="p">,</span> <span class="s1">&#39;10534&#39;</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;key&#39;</span><span class="p">,</span> <span class="s1">&#39;Aw7pItGVKFuZ_FOR3U8VFQ==&#39;</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;ssh_keys&#39;</span><span class="p">,</span> <span class="n">SSH_KEY_CONTENT</span><span class="p">)</span>
<span class="p">])</span>

<span class="n">r</span> <span class="o">=</span> <span class="n">requests</span><span class="o">.</span><span class="n">post</span><span class="p">(</span><span class="n">UPLOAD_URL</span><span class="p">,</span> <span class="n">params</span><span class="o">=</span><span class="n">fields</span><span class="p">)</span>
<span class="k">print</span><span class="p">(</span><span class="n">r</span><span class="o">.</span><span class="n">text</span><span class="p">)</span>
</pre></div>
</div>
<div class="highlight-bash"><div class="highlight"><pre><span></span><span class="nv">REQUEST_SFTP_ACCESS_URL</span><span class="o">=</span><span class="s2">&quot;https://upgrade.odoo.com/database/v1/request_sftp_access&quot;</span>
<span class="nv">SSH_KEYS</span><span class="o">=</span>/path/to/your/authorized_keys
<span class="nv">KEY</span><span class="o">=</span><span class="s2">&quot;Aw7pItGVKFuZ_FOR3U8VFQ==&quot;</span>
<span class="nv">REQUEST_ID</span><span class="o">=</span><span class="s2">&quot;10534&quot;</span>
<span class="nv">URL_PARAMS</span><span class="o">=</span><span class="s2">&quot;key=</span><span class="si">${</span><span class="nv">KEY</span><span class="si">}</span><span class="s2">&amp;request=</span><span class="si">${</span><span class="nv">REQUEST_ID</span><span class="si">}</span><span class="s2">&quot;</span>

curl -sS <span class="s2">&quot;</span><span class="si">${</span><span class="nv">REQUEST_SFTP_ACCESS_URL</span><span class="si">}</span><span class="s2">?</span><span class="si">${</span><span class="nv">URL_PARAMS</span><span class="si">}</span><span class="s2">&quot;</span> -F <span class="nv">ssh_keys</span><span class="o">=</span>@<span class="si">${</span><span class="nv">SSH_KEYS</span><span class="si">}</span> &gt; request_sftp_result.json

<span class="c1"># check for failures</span>
<span class="nv">failures</span><span class="o">=</span><span class="k">$(</span>cat request_sftp_result.json <span class="p">|</span> jq -r <span class="s1">&#39;.failures[]&#39;</span><span class="k">)</span>
<span class="k">if</span> <span class="o">[</span> <span class="s2">&quot;</span><span class="nv">$failures</span><span class="s2">&quot;</span> !<span class="o">=</span> <span class="s2">&quot;&quot;</span> <span class="o">]</span><span class="p">;</span> <span class="k">then</span>
  <span class="nb">echo</span> <span class="nv">$failures</span> <span class="p">|</span> jq -r <span class="s1">&#39;.&#39;</span>
  <span class="nb">exit</span> <span class="m">1</span>
<span class="k">fi</span>
</pre></div>
</div>
</div></div></section><section id="id1"><h5 ><code >failures</code></h5><p >The list of errors. See <a href="#upgrade-api-json-failure" class="reference internal"><span class="std std-ref">failures</span></a> for an
explanation about the JSON dictionary returned in case of failure.</p></section><section id="id2"><h5 ><code >request</code></h5><p >If the call is successful, the value associated to the <em >request</em> key
will be a dictionary containing your SFTP connexion parameters:</p><ul ><li ><code >hostname</code>: the host address to connect to</li><li ><code >sftp_port</code>: the port to connect to</li><li ><code >sftp_user</code>: the SFTP user to use for connecting</li><li ><code >shared_file</code>: the filename you need to use (identical to the <code >filename</code> value you have used when creating the request in the <a href="#upgrade-api-create-method" class="reference internal"><span class="std std-ref">create method</span></a>.)</li><li ><code >request_id</code>: the related upgrade request id (only informative, ,not required for the connection)</li><li ><code >sample_command</code>: a sample command using the ‘sftp’ client</li></ul><p >You should normally be able to connect using the sample command as is.</p><p >You will only have access to the <code >shared_file</code>. No other files will be
accessible and you will not be able to create new files in your shared
environment on the SFTP server.</p></section><section id="using-the-sftp-client"><h6 >Using the ‘sftp’ client</h6><p >Once you have successfully connected using your SFTP client, you can upload
your database dump. Here is a sample session using the ‘sftp’ client:</p><div class="highlight-default"><div class="highlight"><pre><span></span>$ sftp -P 2200 user_10534@upgrade.odoo.com
Connected to upgrade.odoo.com.
sftp&gt; put /path/to/openchs.70.cdump openchs.70.cdump
Uploading /path/to/openchs.70.cdump to /openchs.70.cdump
sftp&gt; ls -l openchs.70.cdump
-rw-rw-rw-    0 0        0          849920 Aug 30 15:58 openchs.70.cdump
</pre></div>
</div>
<p >If your connection is interrupted, you can continue your file transfer using
the <code >-a</code> command line switch:</p><div class="highlight-text"><div class="highlight"><pre><span></span>sftp&gt; put -a /path/to/openchs.70.cdump openchs.70.cdump
Resuming upload of /path/to/openchs.70.cdump to /openchs.70.cdump
</pre></div>
</div>
<p >If you don’t want to manually type the command and need to automate your
database upgrade using a script, you can use a batch file or pipe your commands to ‘sftp’:</p><div class="highlight-default"><div class="highlight"><pre><span></span><span class="n">echo</span> <span class="s2">&quot;put /path/to/openchs.70.cdump openchs.70.cdump&quot;</span> <span class="o">|</span> <span class="n">sftp</span> <span class="o">-</span><span class="n">b</span> <span class="o">-</span> <span class="o">-</span><span class="n">P</span> <span class="mi">2200</span> <span class="n">user_10534</span><span class="nd">@upgrade</span><span class="o">.</span><span class="n">odoo</span><span class="o">.</span><span class="n">com</span>
</pre></div>
</div>
<p >The <code >-b</code> parameter takes a filename. If the filename is <code >-</code>, it reads the commands from standard input.</p></section><section id="asking-to-process-your-request"><i id="upgrade-api-process-method"></i><h3 >Asking to process your request</h3><p >This action ask the Upgrade Platform to process your database dump.</p></section><section id="the-process-method"><h4 >The <code >process</code> method</h4><section class="code-function"><h6 ><code>https://upgrade.odoo.com/database/v1/process</code></h6><p >Process a database dump</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >key</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your private key</li><li ><strong >request</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your request id</li></ul></div></div><div class="code-field"><div class="code-field-name">Returns</div><div class="code-field-body">request result</div></div><div class="code-field"><div class="code-field-name">Return type</div><div class="code-field-body">JSON dictionary</div></div></div></section><p >The request id and the private key are obtained using the <a href="#upgrade-api-create-method" class="reference internal"><span class="std std-ref">create method</span></a></p><p >The result is a JSON dictionary containing the list of <code >failures</code>, which
should be empty if everything went fine.</p><div class="content-switcher setup doc-aside"><ul ><li >Python 2</li><li >Bash</li></ul><div class="tabs"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="kn">import</span> <span class="nn">requests</span>

<span class="n">PROCESS_URL</span> <span class="o">=</span> <span class="s2">&quot;https://upgrade.odoo.com/database/v1/process&quot;</span>

<span class="n">fields</span> <span class="o">=</span> <span class="nb">dict</span><span class="p">([</span>
    <span class="p">(</span><span class="s1">&#39;request&#39;</span><span class="p">,</span> <span class="s1">&#39;10534&#39;</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;key&#39;</span><span class="p">,</span> <span class="s1">&#39;Aw7pItGVKFuZ_FOR3U8VFQ==&#39;</span><span class="p">),</span>
<span class="p">])</span>

<span class="n">r</span> <span class="o">=</span> <span class="n">requests</span><span class="o">.</span><span class="n">get</span><span class="p">(</span><span class="n">PROCESS_URL</span><span class="p">,</span> <span class="n">data</span><span class="o">=</span><span class="n">fields</span><span class="p">)</span>
<span class="k">print</span><span class="p">(</span><span class="n">r</span><span class="o">.</span><span class="n">text</span><span class="p">)</span>
</pre></div>
</div>
<div class="highlight-bash"><div class="highlight"><pre><span></span><span class="nv">PROCESS_URL</span><span class="o">=</span><span class="s2">&quot;https://upgrade.odoo.com/database/v1/process&quot;</span>
<span class="nv">KEY</span><span class="o">=</span><span class="s2">&quot;Aw7pItGVKFuZ_FOR3U8VFQ==&quot;</span>
<span class="nv">REQUEST_ID</span><span class="o">=</span><span class="s2">&quot;10534&quot;</span>
<span class="nv">URL_PARAMS</span><span class="o">=</span><span class="s2">&quot;key=</span><span class="si">${</span><span class="nv">KEY</span><span class="si">}</span><span class="s2">&amp;request=</span><span class="si">${</span><span class="nv">REQUEST_ID</span><span class="si">}</span><span class="s2">&quot;</span>
curl -sS <span class="s2">&quot;</span><span class="si">${</span><span class="nv">PROCESS_URL</span><span class="si">}</span><span class="s2">?</span><span class="si">${</span><span class="nv">URL_PARAMS</span><span class="si">}</span><span class="s2">&quot;</span>
</pre></div>
</div>
</div></div></section><section id="asking-to-skip-the-tests"><i id="upgrade-api-skip-tests"></i><h3 >Asking to skip the tests</h3><p >This action asks the Upgrade Platform to skip the tests for your request.
If you don’t want Odoo to test and validate the migration, you can bypass the testing stage and directly get the migrated dump.</p></section><section id="the-skip-test-method"><h4 >The <code >skip_test</code> method</h4><section class="code-function"><h6 ><code>https://upgrade.odoo.com/database/v1/skip_test</code></h6><p >Skip the tests, deliver the upgraded dump, and set the state to ‘delivered’</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >key</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your private key</li><li ><strong >request</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your request id</li></ul></div></div><div class="code-field"><div class="code-field-name">Returns</div><div class="code-field-body">request result</div></div><div class="code-field"><div class="code-field-name">Return type</div><div class="code-field-body">JSON dictionary</div></div></div></section><p >The request id and the private key are obtained using the <a href="#upgrade-api-create-method" class="reference internal"><span class="std std-ref">create method</span></a></p><p >The result is a JSON dictionary containing the list of <code >failures</code>, which
should be empty if everything went fine.</p><div class="content-switcher setup doc-aside"><ul ><li >Python 2</li><li >Bash</li></ul><div class="tabs"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="kn">import</span> <span class="nn">requests</span>

<span class="n">PROCESS_URL</span> <span class="o">=</span> <span class="s2">&quot;https://upgrade.odoo.com/database/v1/skip_test&quot;</span>

<span class="n">fields</span> <span class="o">=</span> <span class="nb">dict</span><span class="p">([</span>
    <span class="p">(</span><span class="s1">&#39;request&#39;</span><span class="p">,</span> <span class="s1">&#39;10534&#39;</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;key&#39;</span><span class="p">,</span> <span class="s1">&#39;Aw7pItGVKFuZ_FOR3U8VFQ==&#39;</span><span class="p">),</span>
<span class="p">])</span>

<span class="n">r</span> <span class="o">=</span> <span class="n">requests</span><span class="o">.</span><span class="n">get</span><span class="p">(</span><span class="n">PROCESS_URL</span><span class="p">,</span> <span class="n">data</span><span class="o">=</span><span class="n">fields</span><span class="p">)</span>
<span class="k">print</span><span class="p">(</span><span class="n">r</span><span class="o">.</span><span class="n">text</span><span class="p">)</span>
</pre></div>
</div>
<div class="highlight-bash"><div class="highlight"><pre><span></span><span class="nv">PROCESS_URL</span><span class="o">=</span><span class="s2">&quot;https://upgrade.odoo.com/database/v1/skip_test&quot;</span>
<span class="nv">KEY</span><span class="o">=</span><span class="s2">&quot;Aw7pItGVKFuZ_FOR3U8VFQ==&quot;</span>
<span class="nv">REQUEST_ID</span><span class="o">=</span><span class="s2">&quot;10534&quot;</span>
<span class="nv">URL_PARAMS</span><span class="o">=</span><span class="s2">&quot;key=</span><span class="si">${</span><span class="nv">KEY</span><span class="si">}</span><span class="s2">&amp;request=</span><span class="si">${</span><span class="nv">REQUEST_ID</span><span class="si">}</span><span class="s2">&quot;</span>
curl -sS <span class="s2">&quot;</span><span class="si">${</span><span class="nv">PROCESS_URL</span><span class="si">}</span><span class="s2">?</span><span class="si">${</span><span class="nv">URL_PARAMS</span><span class="si">}</span><span class="s2">&quot;</span>
</pre></div>
</div>
</div></div></section><section id="obtaining-your-request-status"><i id="upgrade-api-status-method"></i><h3 >Obtaining your request status</h3><p >This action ask the status of your database upgrade request.</p></section><section id="the-status-method"><h4 >The <code >status</code> method</h4><section class="code-function"><h6 ><code>https://upgrade.odoo.com/database/v1/status</code></h6><p >Ask the status of a database upgrade request</p><div class="code-fields"><div class="code-field"><div class="code-field-name">Parameters</div><div class="code-field-body"><ul ><li ><strong >key</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your private key</li><li ><strong >request</strong> (<a href="https://docs.python.org/3/library/stdtypes.html#str" title="(in Python v3.8)" class="external alert-link reference"><code >str</code></a>) – (required) your request id</li></ul></div></div><div class="code-field"><div class="code-field-name">Returns</div><div class="code-field-body">request result</div></div><div class="code-field"><div class="code-field-name">Return type</div><div class="code-field-body">JSON dictionary</div></div></div></section><p >The request id and the private key are obtained using the <a href="#upgrade-api-create-method" class="reference internal"><span class="std std-ref">create method</span></a></p><p >The result is a JSON dictionary containing various information about your
database upgrade request.</p><div class="content-switcher setup doc-aside"><ul ><li >Python 2</li><li >Bash</li></ul><div class="tabs"><div class="highlight-python"><div class="highlight"><pre><span></span><span class="kn">import</span> <span class="nn">requests</span>

<span class="n">PROCESS_URL</span> <span class="o">=</span> <span class="s2">&quot;https://upgrade.odoo.com/database/v1/status&quot;</span>

<span class="n">fields</span> <span class="o">=</span> <span class="nb">dict</span><span class="p">([</span>
    <span class="p">(</span><span class="s1">&#39;request&#39;</span><span class="p">,</span> <span class="s1">&#39;10534&#39;</span><span class="p">),</span>
    <span class="p">(</span><span class="s1">&#39;key&#39;</span><span class="p">,</span> <span class="s1">&#39;Aw7pItGVKFuZ_FOR3U8VFQ==&#39;</span><span class="p">),</span>
<span class="p">])</span>

<span class="n">r</span> <span class="o">=</span> <span class="n">requests</span><span class="o">.</span><span class="n">get</span><span class="p">(</span><span class="n">PROCESS_URL</span><span class="p">,</span> <span class="n">data</span><span class="o">=</span><span class="n">fields</span><span class="p">)</span>
<span class="k">print</span><span class="p">(</span><span class="n">r</span><span class="o">.</span><span class="n">text</span><span class="p">)</span>
</pre></div>
</div>
<div class="highlight-bash"><div class="highlight"><pre><span></span><span class="nv">STATUS_URL</span><span class="o">=</span><span class="s2">&quot;https://upgrade.odoo.com/database/v1/status&quot;</span>
<span class="nv">KEY</span><span class="o">=</span><span class="s2">&quot;Aw7pItGVKFuZ_FOR3U8VFQ==&quot;</span>
<span class="nv">REQUEST_ID</span><span class="o">=</span><span class="s2">&quot;10534&quot;</span>
<span class="nv">URL_PARAMS</span><span class="o">=</span><span class="s2">&quot;key=</span><span class="si">${</span><span class="nv">KEY</span><span class="si">}</span><span class="s2">&amp;request=</span><span class="si">${</span><span class="nv">REQUEST_ID</span><span class="si">}</span><span class="s2">&quot;</span>
curl -sS <span class="s2">&quot;</span><span class="si">${</span><span class="nv">STATUS_URL</span><span class="si">}</span><span class="s2">?</span><span class="si">${</span><span class="nv">URL_PARAMS</span><span class="si">}</span><span class="s2">&quot;</span>
</pre></div>
</div>
</div></div></section><section id="sample-output"><h4 >Sample output</h4><p >The <code >request</code> key contains various useful information about your request:</p><dl ><dt ><code >id</code></dt><dd >the request id</dd><dt ><code >key</code></dt><dd >your private key</dd><dt ><code >email</code></dt><dd >the email address you supplied when creating the request</dd><dt ><code >target</code></dt><dd >the target Odoo version you supplied when creating the request</dd><dt ><code >aim</code></dt><dd >the purpose (test, production) of your database upgrade request you supplied when creating the request</dd><dt ><code >filename</code></dt><dd >the filename you supplied when creating the request</dd><dt ><code >timezone</code></dt><dd >the timezone you supplied when creating the request</dd><dt ><code >state</code></dt><dd >the state of your request</dd><dt ><code >issue_stage</code></dt><dd >the stage of the issue we have create on Odoo main server</dd><dt ><code >issue</code></dt><dd >the id of the issue we have create on Odoo main server</dd><dt ><code >status_url</code></dt><dd >the URL to access your database upgrade request html page</dd><dt ><code >notes_url</code></dt><dd >the URL to get the notes about your database upgrade</dd><dt ><code >original_sql_url</code></dt><dd >the URL used to get your uploaded (not upgraded) database as an SQL stream</dd><dt ><code >original_dump_url</code></dt><dd >the URL used to get your uploaded (not upgraded) database as an archive file</dd><dt ><code >upgraded_sql_url</code></dt><dd >the URL used to get your upgraded database as an SQL stream</dd><dt ><code >upgraded_dump_url</code></dt><dd >the URL used to get your upgraded database as an archive file</dd><dt ><code >modules_url</code></dt><dd >the URL used to get your custom modules</dd><dt ><code >filesize</code></dt><dd >the size of your uploaded database file</dd><dt ><code >database_uuid</code></dt><dd >the Unique ID of your database</dd><dt ><code >created_at</code></dt><dd >the date when you created the request</dd><dt ><code >estimated_time</code></dt><dd >an estimation of the time it takes to upgrade your database</dd><dt ><code >processed_at</code></dt><dd >time when your database upgrade was started</dd><dt ><code >elapsed</code></dt><dd >the time it takes to upgrade your database</dd><dt ><code >filestore</code></dt><dd >your attachments were converted to the filestore</dd><dt ><code >customer_message</code></dt><dd >an important message related to your request</dd><dt ><code >database_version</code></dt><dd >the guessed Odoo version of your uploaded (not upgraded) database</dd><dt ><code >postgresql</code></dt><dd >the guessed Postgresql version of your uploaded (not upgraded) database</dd><dt ><code >compressions</code></dt><dd >the compression methods used by your uploaded database</dd></dl><div class="content-switcher setup doc-aside"><ul ><li >JSON</li></ul><div class="tabs"><div class="highlight-json"><div class="highlight"><pre><span></span><span class="p">{</span>
  <span class="nt">&quot;failures&quot;</span><span class="p">:</span> <span class="p">[],</span>
  <span class="nt">&quot;request&quot;</span><span class="p">:</span> <span class="p">{</span>
    <span class="nt">&quot;id&quot;</span><span class="p">:</span> <span class="mi">10534</span><span class="p">,</span>
    <span class="nt">&quot;key&quot;</span><span class="p">:</span> <span class="s2">&quot;Aw7pItGVKFuZ_FOR3U8VFQ==&quot;</span><span class="p">,</span>
    <span class="nt">&quot;email&quot;</span><span class="p">:</span> <span class="s2">&quot;john.doe@example.com&quot;</span><span class="p">,</span>
    <span class="nt">&quot;target&quot;</span><span class="p">:</span> <span class="s2">&quot;12.0&quot;</span><span class="p">,</span>
    <span class="nt">&quot;aim&quot;</span><span class="p">:</span> <span class="s2">&quot;test&quot;</span><span class="p">,</span>
    <span class="nt">&quot;filename&quot;</span><span class="p">:</span> <span class="s2">&quot;db_name.dump&quot;</span><span class="p">,</span>
    <span class="nt">&quot;timezone&quot;</span><span class="p">:</span> <span class="kc">null</span><span class="p">,</span>
    <span class="nt">&quot;state&quot;</span><span class="p">:</span> <span class="s2">&quot;draft&quot;</span><span class="p">,</span>
    <span class="nt">&quot;issue_stage&quot;</span><span class="p">:</span> <span class="s2">&quot;new&quot;</span><span class="p">,</span>
    <span class="nt">&quot;issue&quot;</span><span class="p">:</span> <span class="mi">648398</span><span class="p">,</span>
    <span class="nt">&quot;status_url&quot;</span><span class="p">:</span> <span class="s2">&quot;https://upgrade.odoo.com/database/eu1/10534/Aw7pItGVKFuZ_FOR3U8VFQ==/status&quot;</span><span class="p">,</span>
    <span class="nt">&quot;notes_url&quot;</span><span class="p">:</span> <span class="s2">&quot;https://upgrade.odoo.com/database/eu1/10534/Aw7pItGVKFuZ_FOR3U8VFQ==/upgraded/notes&quot;</span><span class="p">,</span>
    <span class="nt">&quot;original_sql_url&quot;</span><span class="p">:</span> <span class="s2">&quot;https://upgrade.odoo.com/database/eu1/10534/Aw7pItGVKFuZ_FOR3U8VFQ==/original/sql&quot;</span><span class="p">,</span>
    <span class="nt">&quot;original_dump_url&quot;</span><span class="p">:</span> <span class="s2">&quot;https://upgrade.odoo.com/database/eu1/10534/Aw7pItGVKFuZ_FOR3U8VFQ==/original/archive&quot;</span><span class="p">,</span>
    <span class="nt">&quot;upgraded_sql_url&quot;</span><span class="p">:</span> <span class="s2">&quot;https://upgrade.odoo.com/database/eu1/10534/Aw7pItGVKFuZ_FOR3U8VFQ==/upgraded/sql&quot;</span><span class="p">,</span>
    <span class="nt">&quot;upgraded_dump_url&quot;</span><span class="p">:</span> <span class="s2">&quot;https://upgrade.odoo.com/database/eu1/10534/Aw7pItGVKFuZ_FOR3U8VFQ==/upgraded/archive&quot;</span><span class="p">,</span>
    <span class="nt">&quot;modules_url&quot;</span><span class="p">:</span> <span class="s2">&quot;https://upgrade.odoo.com/database/eu1/10534/Aw7pItGVKFuZ_FOR3U8VFQ==/modules/archive&quot;</span><span class="p">,</span>
    <span class="nt">&quot;filesize&quot;</span><span class="p">:</span> <span class="s2">&quot;912.99 Kb&quot;</span><span class="p">,</span>
    <span class="nt">&quot;database_uuid&quot;</span><span class="p">:</span> <span class="kc">null</span><span class="p">,</span>
    <span class="nt">&quot;created_at&quot;</span><span class="p">:</span> <span class="s2">&quot;2018-09-09 07:13:49&quot;</span><span class="p">,</span>
    <span class="nt">&quot;estimated_time&quot;</span><span class="p">:</span> <span class="kc">null</span><span class="p">,</span>
    <span class="nt">&quot;processed_at&quot;</span><span class="p">:</span> <span class="kc">null</span><span class="p">,</span>
    <span class="nt">&quot;elapsed&quot;</span><span class="p">:</span> <span class="s2">&quot;00:00&quot;</span><span class="p">,</span>
    <span class="nt">&quot;filestore&quot;</span><span class="p">:</span> <span class="kc">false</span><span class="p">,</span>
    <span class="nt">&quot;customer_message&quot;</span><span class="p">:</span> <span class="kc">null</span><span class="p">,</span>
    <span class="nt">&quot;database_version&quot;</span><span class="p">:</span> <span class="kc">null</span><span class="p">,</span>
    <span class="nt">&quot;postgresql&quot;</span><span class="p">:</span> <span class="s2">&quot;9.4&quot;</span><span class="p">,</span>
    <span class="nt">&quot;compressions&quot;</span><span class="p">:</span> <span class="p">[</span>
      <span class="s2">&quot;pgdmp_custom&quot;</span><span class="p">,</span>
      <span class="s2">&quot;sql&quot;</span>
    <span class="p">]</span>
  <span class="p">}</span>
<span class="p">}</span>
</pre></div>
</div>
</div></div></section><section id="downloading-your-database-dump"><i id="upgrade-api-download-method"></i><h3 >Downloading your database dump</h3><p >Beside downloading your migrated database using the URL provided by the
<a href="#upgrade-api-status-method" class="reference internal"><span class="std std-ref">status method</span></a>, you can also use the SFTP
protocol as described in the <a href="#upgrade-api-request-sftp-access-method" class="reference internal"><span class="std std-ref">request_sftp_access method</span></a></p><p >The diffence is that you’ll only be able to download the migrated database. No
uploading will be possible.</p><p >Your database upgrade request should be in the <code >done</code> state.</p><p >Once you have successfully connected using your SFTP client, you can download
your database dump. Here is a sample session using the ‘sftp’ client:</p><div class="highlight-default"><div class="highlight"><pre><span></span>$ sftp -P 2200 user_10534@upgrade.odoo.com
Connected to upgrade.odoo.com.
sftp&gt; get upgraded_openchs.70.cdump /path/to/upgraded_openchs.70.cdump
Downloading /upgraded_openchs.70.cdump to /path/to/upgraded_openchs.70.cdump
</pre></div>
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