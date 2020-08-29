<!doctype html>

<html xmlns="http://www.w3.org/1999/xhtml">
  
<!-- Mirrored from www.odoo.com/documentation/13.0/webservices/localization.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Aug 2020 10:08:09 GMT -->
<head>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:500,600" rel="stylesheet">
  
    <title>Creating a Localization &#8212; odoo 13.0 documentation</title>
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
    <script type="text/javascript" src="../_static/patchqueue.js"></script><link rel="canonical" href="localization.html" />
  
    <link rel="index" title="Index" href="https://www.odoo.com/documentation/13.0/genindex.html" />
    <link rel="search" title="Search" href="https://www.odoo.com/documentation/13.0/search.html" />
    <link rel="next" title="Setting Up" href="https://www.odoo.com/documentation/13.0/setup.html" />
    <link rel="prev" title="Database Upgrade" href="upgrade.html" /> 
  </head><body>
    <header> 
      <?php
       include('header.php');
    ?>
  </header><div id="wrap" class="">
    
    
    
    <figure class="card top has_banner">
      <span class="card-img" style="background-image: url('../_static/banners/localization.jpg');"></span>
      <div class="container text-center">
        <h1> Creating a Localization </h1>
      </div>
    </figure>
    
    
    
      <main class="container ">
        
        <div class="o_content row">
          
          <aside>
            <div class="navbar-aside text-center">
              <ul class="text-left nav list-group"><li class="list-group-item"><a href="#building-a-localization-module" class="reference ripple internal">Building a localization module</a></li><li class="list-group-item"><a href="#configuring-my-own-chart-of-accounts" class="reference ripple internal">Configuring my own Chart of Accounts?</a><ul ><li class="list-group-item"><a href="#adding-a-new-account-to-my-chart-of-accounts" class="reference ripple internal">Adding a new account to my Chart of Accounts</a></li><li class="list-group-item"><a href="#adding-a-new-tax-to-my-chart-of-accounts" class="reference ripple internal">Adding a new tax to my Chart of Accounts</a></li><li class="list-group-item"><a href="#adding-a-new-fiscal-position-to-my-chart-of-accounts" class="reference ripple internal">Adding a new fiscal position to my Chart of Accounts</a></li><li class="list-group-item"><a href="#adding-the-properties-to-my-chart-of-accounts" class="reference ripple internal">Adding the properties to my Chart of Accounts</a></li></ul></li><li class="list-group-item"><a href="#how-to-create-a-new-bank-operation-model" class="reference ripple internal">How to create a new bank operation model?</a></li><li class="list-group-item"><a href="#how-to-create-a-new-dynamic-report" class="reference ripple internal">How to create a new dynamic report?</a></li></ul>
              
              <p class="gith-container"><a href="https://github.com/odoo/odoo/edit/13.0/doc/webservices/localization.rst" class="gith-link">
                  Edit on GitHub
              </a></p>
              
            </div>
          </aside>
          
          <article class="doc-body ">
            
            
  <section id="creating-a-localization"><div role="alert" class="alert alert-warning"><h3 class="alert-title">Warning</h3><p >This tutorial requires knowledges about how to build a module in Odoo (see
<a href="https://www.odoo.com/documentation/13.0/howtos/backend.html" class="alert-link reference internal"><span class="doc">Building a Module</span></a>).</p></div></section><section id="building-a-localization-module"><h2 >Building a localization module</h2><p >When installing the <code >accounting</code> module, the localization module corresponding to the country code of the company is installed automatically.
In case of no country code set or no localization module found, the <code >l10n_generic_coa</code> (US) localization module is installed by default.</p><p >For example, <code >l10n_be</code> will be installed if the company has <code >Belgium</code> as country.</p><p >This behavior is allowed by the presence of a <em >.xml</em> file containing the following code:</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;function</span> <span class="na">model=</span><span class="s">&quot;account.chart.template&quot;</span> <span class="na">name=</span><span class="s">&quot;try_loading_for_current_company&quot;</span><span class="nt">&gt;</span>
   <span class="nt">&lt;value</span> <span class="na">eval=</span><span class="s">&quot;[ref(module.template_xmlid)]&quot;</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/function&gt;</span>
</pre></div>
</div>
<p >Where <code >module.template_xmlid</code> is the <strong >fully-qualified</strong> xmlid of the corresponding template.</p><p >Usually located in the <code >data</code> folder, it must be loaded at the very last in the <code >__manifest__.py</code> file.</p><div role="alert" class="alert-danger alert"><h3 class="alert-title">Danger</h3><p >If the <em >.xml</em> file is missing, the right chart of accounts won’t be loaded on time!</p></div></section><section id="configuring-my-own-chart-of-accounts"><h2 >Configuring my own Chart of Accounts?</h2><p >First of all, before I proceed, we need to talk about the templates. A template is a record that allows replica of itself.
This mechanism is needed when working in multi-companies. For example, the creation of a new account is done using the <code >account.account.template</code> model.
However, each company using this chart of accounts will be linked to a replica having <code >account.account</code> as model.
So, the templates are never used directly by the company.</p><p >Then, when a chart of accounts needs to be installed, all templates dependent of this one will create a replica and link this newly generated record to the company’s user.
It means all such templates must be linked to the chart of accounts in some way. To do so, each one must reference the desired chart of accounts using the <code >chart_template_id</code> field.
For this reason, we need to define an instance of the <code >account.chart.template</code> model before creating its templates.</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;...&quot;</span> <span class="na">model=</span><span class="s">&quot;account.chart.template&quot;</span><span class="nt">&gt;</span>
    <span class="c">&lt;!-- [Required] Specify the name to display for this CoA. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Required] Specify the currency. E.g. &quot;base.USD&quot;. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;currency_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Required] Specify a prefix of the bank accounts. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;bank_account_code_prefix&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Required] Specify a prefix of the cash accounts. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;cash_account_code_prefix&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Optional] Define a parent chart of accounts that will be installed just before this one. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;parent_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Define the number of digits of account codes. By default, the value is 6. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;code_digits&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Optional] Boolean to show or not this CoA on the list. By default, the CoA is visible.</span>
<span class="c">     This field is mostly used when this CoA has some children (see parent_id field). --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;visible&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Boolean to enable the Anglo-Saxon accounting. By default, this field is False. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;use_anglo_saxon&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Boolean to enable the complete set of taxes. By default, this field is True.</span>
<span class="c">    This boolean helps you to choose if you want to propose to the user to encode the sale and purchase rates or choose from list of taxes.</span>
<span class="c">    This last choice assumes that the set of tax defined on this template is complete. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;complete_tax_set&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Specify the spoken languages.</span>
<span class="c">    /!\ This option is only available if your module depends of l10n_multilang.</span>
<span class="c">    You must provide the language codes separated by &#39;;&#39;, e.g. eval=&quot;&#39;en_US;ar_EG;ar_SY&#39;&quot;. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;spoken_languages&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
<p >For example, let’s take a look to the Belgium chart of accounts.</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;l10nbe_chart_template&quot;</span> <span class="na">model=</span><span class="s">&quot;account.chart.template&quot;</span><span class="nt">&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>Belgian PCMN<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;currency_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;base.EUR&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;bank_account_code_prefix&quot;</span><span class="nt">&gt;</span>550<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;cash_account_code_prefix&quot;</span><span class="nt">&gt;</span>570<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;spoken_languages&quot;</span> <span class="na">eval=</span><span class="s">&quot;&#39;nl_BE&#39;&quot;</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
<p >Now that the chart of accounts is created, we can focus on the creation of the templates.
As said previously, each record must reference this record through the <code >chart_template_id</code> field.
If not, the template will be ignored. The following sections show in details how to create these templates.</p></section><section id="adding-a-new-account-to-my-chart-of-accounts"><h3 >Adding a new account to my Chart of Accounts</h3><p >It’s time to create our accounts. It consists to creating records of <code >account.account.template</code> type.
Each <code >account.account.template</code> is able to create an <code >account.account</code> for each company.</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;...&quot;</span> <span class="na">model=</span><span class="s">&quot;account.account.template&quot;</span><span class="nt">&gt;</span>
    <span class="c">&lt;!-- [Required] Specify the name to display for this account. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Required] Specify a code. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;code&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Required] Specify a type. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;user_type_id&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Required] Set the CoA owning this account. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;chart_template_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Specify a secondary currency for each account.move.line linked to this account. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;currency_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Boolean to allow the user to reconcile entries in this account. True by default. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;reconcile&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Specify a group for this account. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;group_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">&gt;</span>

    <span class="c">&lt;!-- [Optional] Specify some tags. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;tag_ids&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
<p >Some of the described fields above deserve a bit more explanation.</p><p >The <code >user_type_id</code> field requires a value of type <code >account.account.type</code>.
Although some additional types could be created in a localization module, we encourage the usage of the existing types in the <a href="https://github.com/odoo/odoo/blob/13.0/addons/account/data/data_account_type.xml" class="external reference">account/data/data_account_type.xml</a> file.
The usage of these generic types ensures the generic reports working correctly in addition to those that you could create in your localization module.</p><div role="alert" class="alert alert-warning"><h3 class="alert-title">Warning</h3><p >Avoid the usage of liquidity <code >account.account.type</code>!
Indeed, the bank &amp; cash accounts are created directly at the installation of the localization module and then, are linked to an <code >account.journal</code>.</p></div><div role="alert" class="alert alert-warning"><h3 class="alert-title">Warning</h3><p >Only one account of type payable/receivable is enough.</p></div><p >Although the <code >tag_ids</code> field is optional, this one remains a very powerful feature.
Indeed, this one allows you to define some tags for your accounts to spread them correctly on your reports.
For example, suppose you want to create a financial report having multiple lines but you have no way to find a rule to dispatch the accounts according their <code >code</code> or <code >name</code>.
The solution is the usage of tags, one for each report line, to spread and aggregate your accounts like you want.</p><p >Like any other record, a tag can be created with the following xml structure:</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;...&quot;</span> <span class="na">model=</span><span class="s">&quot;account.account.tag&quot;</span><span class="nt">&gt;</span>
    <span class="c">&lt;!-- [Required] Specify the name to display for this tag. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Optional] Define a scope for this applicability.</span>
<span class="c">    The available keys are &#39;accounts&#39; and &#39;taxes&#39; but &#39;accounts&#39; is the default value. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;applicability&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
<p >As you can well imagine with the usage of tags, this feature can also be used with taxes.</p><p >An examples coming from the <code >l10n_be</code> module:</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;a4000&quot;</span> <span class="na">model=</span><span class="s">&quot;account.account.template&quot;</span><span class="nt">&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>Clients<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;code&quot;</span><span class="nt">&gt;</span>4000<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;user_type_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;account.data_account_type_receivable&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;chart_template_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;l10nbe_chart_template&quot;</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
<div role="alert" class="alert alert-warning"><h3 class="alert-title">Warning</h3><p >Don’t create too much accounts: 200-300 is enough.</p></div></section><section id="adding-a-new-tax-to-my-chart-of-accounts"><h3 >Adding a new tax to my Chart of Accounts</h3><p >To create a new tax record, you just need to follow the same process as the creation of accounts.
The only difference being that you must use the <code >account.tax.template</code> model.</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;...&quot;</span> <span class="na">model=</span><span class="s">&quot;account.tax.template&quot;</span><span class="nt">&gt;</span>
    <span class="c">&lt;!-- [Required] Specify the name to display for this tax. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Required] Specify the amount.</span>
<span class="c">    E.g. 7 with fixed amount_type means v + 7 if v is the amount on which the tax is applied.</span>
<span class="c">     If amount_type is &#39;percent&#39;, the tax amount is v * 0.07. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;amount&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Required] Set the CoA owning this tax. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;chart_template_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Required/Optional] Define an account if the tax is not a group of taxes. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Required/Optional] Define an refund account if the tax is not a group of taxes. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;refund_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Define the tax&#39;s type.</span>
<span class="c">    &#39;sale&#39;, &#39;purchase&#39; or &#39;none&#39; are the allowed values. &#39;sale&#39; is the default value.</span>
<span class="c">    Note: &#39;none&#39; means a tax can&#39;t be used by itself, however it can still be used in a group. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;type_tax_use&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Optional] Define the type of amount:</span>
<span class="c">    &#39;group&#39; for a group of taxes, &#39;fixed&#39; for a tax with a fixed amount or &#39;percent&#39; for a classic percentage of price.</span>
<span class="c">    By default, the type of amount is percentage. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;amount_type&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Define some children taxes.</span>
<span class="c">    /!\ Should be used only with an amount_type with &#39;group&#39; set. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;children_tax_ids&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] The sequence field is used to define order in which the tax lines are applied.</span>
<span class="c">    By default, sequence = 1. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;sequence&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Specify a short text to be displayed on invoices.</span>
<span class="c">    For example, a tax named &quot;15% on Services&quot; can have the following label on invoice &quot;15%&quot;. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;description&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Optional] Boolean that indicates if the amount should be considered as included in price. False by default.</span>
<span class="c">    E.g. Suppose v = 132 and a tax amount of 20.</span>
<span class="c">    If price_include = False, the computed amount will be 132 * 0.2 = 26.4.</span>
<span class="c">    If price_include = True, the computed amount will be 132 - (132 / 1.2) = 132 - 110 = 22. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;price_include&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Boolean to set to include the amount to the base. False by default.</span>
<span class="c">     If True, the subsequent taxes will be computed based on the base tax amount plus the amount of this tax.</span>
<span class="c">     E.g. suppose v = 100, t1, a tax of 10% and another tax t2 with 20%.</span>
<span class="c">     If t1 doesn&#39;t affects the base,</span>
<span class="c">     t1 amount = 100 * 0.1 = 10 and t2 amount = 100 * 0.2 = 20.</span>
<span class="c">     If t1 affects the base,</span>
<span class="c">     t1 amount = 100 * 0.1 = 10 and t2 amount = 110 * 0.2 = 22.  --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;include_base_amount&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Boolean false by default.</span>
<span class="c">     If set, the amount computed by this tax will be assigned to the same analytic account as the invoice line (if any). --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;analytic&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Specify some tags.</span>
<span class="c">    These tags must have &#39;taxes&#39; as applicability.</span>
<span class="c">    See the previous section for more details. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;tag_ids&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">&gt;</span>

    <span class="c">&lt;!-- [Optional] Define a tax group used to display the sums of taxes in the invoices. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;tax_group_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Define the tax exigibility either based on invoice (&#39;on_invoice&#39; value) or</span>
<span class="c">    either based on payment using the &#39;on_payment&#39; key.</span>
<span class="c">    The default value is &#39;on_invoice&#39;. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;tax_exigibility&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Optional] Define a cash basis account in case of tax exigibility &#39;on_payment&#39;. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;cash_basis_account&quot;</span> <span class="na">red=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
<p >An example found in the <code >l10n_pl</code> module:</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;vp_leas_sale&quot;</span> <span class="na">model=</span><span class="s">&quot;account.tax.template&quot;</span><span class="nt">&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;chart_template_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;pl_chart_template&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>VAT - leasing pojazdu(sale)<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;description&quot;</span><span class="nt">&gt;</span>VLP<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;amount&quot;</span><span class="nt">&gt;</span>1.00<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;sequence&quot;</span> <span class="na">eval=</span><span class="s">&quot;1&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;amount_type&quot;</span><span class="nt">&gt;</span>group<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;type_tax_use&quot;</span><span class="nt">&gt;</span>sale<span class="nt">&lt;/field&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;children_tax_ids&quot;</span> <span class="na">eval=</span><span class="s">&quot;[(6, 0, [ref(&#39;vp_leas_sale_1&#39;), ref(&#39;vp_leas_sale_2&#39;)])]&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;tag_ids&quot;</span> <span class="na">eval=</span><span class="s">&quot;[(6,0,[ref(&#39;l10n_pl.tag_pl_21&#39;)])]&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;tax_group_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;tax_group_vat_23&quot;</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
</section><section id="adding-a-new-fiscal-position-to-my-chart-of-accounts"><h3 >Adding a new fiscal position to my Chart of Accounts</h3><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><p >If you need more information about what is a fiscal position and how it works in Odoo, please refer to <a href="https://www.odoo.com/documentation/user/online/accounting/others/taxes/application.html" class="external alert-link reference">How to adapt taxes to my customer status or localization</a>.</p></div><p >To create a new fiscal position, simply use the <code >account.fiscal.position.template</code> model:</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;...&quot;</span> <span class="na">model=</span><span class="s">&quot;account.fiscal.position.template&quot;</span><span class="nt">&gt;</span>
    <span class="c">&lt;!-- [Required] Specify the name to display for this fiscal position. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

    <span class="c">&lt;!-- [Required] Set the CoA owning this fiscal position. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;chart_template_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

    <span class="c">&lt;!-- [Optional] Add some additional notes. --&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;note&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
</section><section id="adding-the-properties-to-my-chart-of-accounts"><h3 >Adding the properties to my Chart of Accounts</h3><p >When the whole accounts are generated, you have the possibility to override the newly generated chart of accounts by adding some properties that correspond to default accounts used in certain situations.
This must be done after the creation of accounts before each one must be linked to the chart of accounts.</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="cp">&lt;?xml version=&quot;1.0&quot; encoding=&quot;utf-8&quot;?&gt;</span>
<span class="nt">&lt;odoo&gt;</span>
    <span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;l10n_xx_chart_template&quot;</span> <span class="na">model=</span><span class="s">&quot;account.chart.template&quot;</span><span class="nt">&gt;</span>

        <span class="c">&lt;!-- Define receivable/payable accounts. --&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_account_receivable_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_account_payable_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

        <span class="c">&lt;!-- Define categories of expense/income account. --&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_account_expense_categ_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_account_income_categ_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

        <span class="c">&lt;!-- Define input/output accounts for stock valuation. --&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_stock_account_input_categ_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_stock_account_output_categ_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

        <span class="c">&lt;!-- Define an account template for stock valuation. --&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_stock_valuation_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

        <span class="c">&lt;!-- Define loss/gain exchange rate accounts. --&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;expense_currency_exchange_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;income_currency_exchange_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

        <span class="c">&lt;!-- Define a transfer account. --&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;transfer_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;/record&gt;</span>
<span class="nt">&lt;/odoo&gt;</span>
</pre></div>
</div>
<p >For example, let’s come back to the Belgium PCMN. This chart of accounts is override in this way to add some properties.</p><div class="highlight-xml"><div class="highlight"><pre><span></span><span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;l10nbe_chart_template&quot;</span> <span class="na">model=</span><span class="s">&quot;account.chart.template&quot;</span><span class="nt">&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_account_receivable_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;a4000&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_account_payable_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;a440&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_account_expense_categ_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;a600&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;property_account_income_categ_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;a7010&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;expense_currency_exchange_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;a654&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;income_currency_exchange_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;a754&quot;</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;transfer_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;trans&quot;</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
</section><section id="how-to-create-a-new-bank-operation-model"><h2 >How to create a new bank operation model?</h2><div role="alert" class="alert alert-info"><h3 class="alert-title">Note</h3><p >How a bank operation model works exactly in Odoo? See <a href="https://www.odoo.com/documentation/user/online/accounting/bank/reconciliation/configure.html" class="external alert-link reference">Configure model of entries</a>.</p></div><p >Since <code >V10</code>, a new feature is available in the bank statement reconciliation widget: the bank operation model.
This allows the user to pre-fill some accounting entries with a single click.
The creation of an <code >account.reconcile.model.template</code> record is quite easy:</p><div class="highlight-xml"><div class="highlight"><pre><span></span> <span class="nt">&lt;record</span> <span class="na">id=</span><span class="s">&quot;...&quot;</span> <span class="na">model=</span><span class="s">&quot;account.reconcile.model.template&quot;</span><span class="nt">&gt;</span>
     <span class="c">&lt;!-- [Required] Specify the name to display. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;name&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

     <span class="c">&lt;!-- [Required] Set the CoA owning this. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;chart_template_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

     <span class="c">&lt;!-- [Optional] Set a sequence number defining the order in which it will be displayed.</span>
<span class="c">     By default, the sequence is 10. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;sequence&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

     <span class="c">&lt;!-- [Optional] Define an account. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

     <span class="c">&lt;!-- [Optional] Define a label to be added to the journal item. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;label&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

     <span class="c">&lt;!-- [Optional] Define the type of amount_type, either &#39;fixed&#39; or &#39;percentage&#39;.</span>
<span class="c">     The last one is the default value. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;amount_type&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

     <span class="c">&lt;!-- [Optional] Define the balance amount on which this model will be applied to (100 by default).</span>
<span class="c">     Fixed amount will count as a debit if it is negative, as a credit if it is positive. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;amount&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>

     <span class="c">&lt;!-- [Optional] Define eventually a tax. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;tax_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>

     <span class="c">&lt;!-- [Optional] The sames fields are available twice.</span>
<span class="c">     To enable a second journal line, you can set this field to true and</span>
<span class="c">     fill the fields accordingly. --&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;has_second_line&quot;</span> <span class="na">eval=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;second_account_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;second_label&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;second_amount_type&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;second_amount&quot;</span><span class="nt">&gt;</span>...<span class="nt">&lt;/field&gt;</span>
     <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">&quot;second_tax_id&quot;</span> <span class="na">ref=</span><span class="s">&quot;...&quot;</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/record&gt;</span>
</pre></div>
</div>
</section><section id="how-to-create-a-new-dynamic-report"><h2 >How to create a new dynamic report?</h2><p >If you need to add some reports on your localization, you need to create a new module named <strong >l10n_xx_reports</strong>.
Furthermore, this additional module must be present in the <code >enterprise</code> repository and must have at least two dependencies,
one to bring all the stuff for your localization module and one more, <code >account_reports</code>, to design dynamic reports.</p><div class="highlight-py"><div class="highlight"><pre><span></span><span class="s1">&#39;depends&#39;</span><span class="p">:</span> <span class="p">[</span><span class="s1">&#39;l10n_xx&#39;</span><span class="p">,</span> <span class="s1">&#39;account_reports&#39;</span><span class="p">],</span>
</pre></div>
</div>
<p >Once it’s done, you can start the creation of your report statements. The documentation is available in the following <a href="https://www.odoo.com/slides/slide/how-to-create-custom-accounting-report-415" class="external reference">slides</a>.</p></section>

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

<!-- Mirrored from www.odoo.com/documentation/13.0/webservices/localization.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Aug 2020 10:08:10 GMT -->
</html>