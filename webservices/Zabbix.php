<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zabbnet</title>
    <link rel="stylesheet" href="../_static/style.css" type="text/css" />
    <link rel="stylesheet" href="../_static/pygments.css" type="text/css" />
    <link rel="stylesheet" href="../_static/patchqueue.css" type="text/css" />
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../_static/documentation_options.js"></script>
    <script type="text/javascript" src="../_static/jquery.js"></script>
    <script type="text/javascript" src="../_static/underscore.js"></script>
    <script type="text/javascript" src="../_static/doctools.js"></script>
    <script type="text/javascript" src="../_static/jquery.min.js"></script>
    <script type="text/javascript" src="../_static/bootstrap.js"></script>
    <script type="text/javascript" src="../_static/doc.js"></script>
    <script type="text/javascript" src="../_static/jquery.noconflict.js"></script>
    <script type="text/javascript" src="../_static/patchqueue.js">
    </script><link rel="canonical" href="Zabbix.html" />
</head>
  <header> 
    <?php
      include('header.php');
    ?>
  </header>
  <div id="wrap" class="has_code_col">
    <figure class="card top has_banner">
      <span class="card-img" style="background-image: url('../_static/banners/web_service_api.jpg');"></span>
      <div class="container text-center">
        <h1> Zabbix Server Installation</h1>
      </div>
    </figure>    
      <main class="container has_code_col">
        <div class="o_content row">
          <aside>
            <div class="navbar-aside text-center">
              <ul class="text-left nav list-group"><li class="list-group-item"><a href="#connection" class="reference ripple internal">Connection</a><ul ><li class="list-group-item"><a href="#configuration" class="reference ripple internal">Configuration</a><ul ><li class="list-group-item"><a href="#demo" class="reference ripple internal">demo</a></li></ul></li><li class="list-group-item"><a href="#logging-in" class="reference ripple internal">Logging in</a></li></ul></li><li class="list-group-item"><a href="#calling-methods" class="reference ripple internal">Calling methods</a><ul ><li class="list-group-item"><a href="#list-records" class="reference ripple internal">List records</a><ul ><li class="list-group-item"><a href="#pagination" class="reference ripple internal">Pagination</a></li></ul></li><li class="list-group-item"><a href="#count-records" class="reference ripple internal">Count records</a></li><li class="list-group-item"><a href="#read-records" class="reference ripple internal">Read records</a></li><li class="list-group-item"><a href="#listing-record-fields" class="reference ripple internal">Listing record fields</a></li><li class="list-group-item"><a href="#search-and-read" class="reference ripple internal">Search and read</a></li><li class="list-group-item"><a href="#create-records" class="reference ripple internal">Create records</a></li><li class="list-group-item"><a href="#update-records" class="reference ripple internal">Update records</a></li><li class="list-group-item"><a href="#delete-records" class="reference ripple internal">Delete records</a></li><li class="list-group-item"><a href="#inspection-and-introspection" class="reference ripple internal">Inspection and introspection</a><ul ><li class="list-group-item"><a href="#ir-model" class="reference ripple internal"><code >ir.model</code></a></li><li class="list-group-item"><a href="#ir-model-fields" class="reference ripple internal"><code >ir.model.fields</code></a></li></ul></li></ul></li></ul>
              <p class="gith-container"><a href="https://github.com/odoo/odoo/edit/13.0/doc/webservices/odoo.rst" class="gith-link">
                  Edit on GitHub
              </a></p>
            </div>
          </aside>
          <article class="doc-body ">
          	<section id="external-api">
          		<p >Zabbix is software that monitors numerous parameters of a network and the health and integrity of servers. Zabbix uses a flexible notification mechanism that allows users to configure e-mail based alerts for virtually any event. This allows a fast reaction to server problems. Zabbix offers excellent reporting and data visualisation features based on the stored data. This makes Zabbix ideal for capacity planning.</p>
              <p>Zabbix supports both polling and trapping. All Zabbix reports and statistics, as well as configuration parameters, are accessed through a web-based frontend. A web-based frontend ensures that the status of your network and the health of your servers can be assessed from any location. Zabbix can play an important role in monitoring IT infrastructure. This is equally true for small organisations with a few servers and for large companies with a multitude of servers.</p>
          	</section>
          	<section id="connection">
          		<h2 >Installation</h2>
          	</section>
          	<section id="configuration">
          		<h3 >Requirements</h3>
              <p>Zabbix hardware and software requirements are as follows:</p>

              <h4>Hardware Requirements</h4>

              <h5>Memory</h5>
              <p>Zabbix requires both physical and disk memory. 128 MB of physical memory and 256 MB of free disk space could be a good starting point. However, the amount of required disk memory obviously depends on the number of hosts and parameters that are being monitored.Each Zabbix daemon process requires several connections to a database server. Amount of memory allocated for the connection depends on configuration of the database engine.</p>
              <h5>CPU</h5>
              <p>Zabbix and especially Zabbix database may require significant CPU resources depending on number of monitored parameters and chosen database engine.</p>
              <div class="content-switcher setup doc-aside">
                <ul >
                  <li >Small</li>
                  <li>Medium</li>
                  <li>Large</li>
                  <li>Very large</li>
                </ul>
                <div class="tabs">
                  <div class="highlight-python3">
                    <div class="highlight">
                      <pre><span></span>
                        <span class="kn">Platform :</span><span class="nn"> Centos</span>
                        <span class="kn">CPU/Memory :</span><span class="nn"> Virtual Appliance</span>
                        <span class="kn">Database :</span><span class="nn"> MySQL InnoDB</span>
                        <span class="kn">Monitored hosts :</span><span class="nn"> 100</span>
                      </pre>
                    </div>
                  </div>
                  <div class="highlight-python3">
                    <div class="highlight">
                      <pre><span></span>
                        <span class="kn">Platform :</span><span class="nn"> Centos</span>
                        <span class="kn">CPU/Memory :</span><span class="nn"> 2 CPU cores/2GB</span>
                        <span class="kn">Database :</span><span class="nn"> MySQL InnoDB</span>
                        <span class="kn">Monitored hosts :</span><span class="nn"> 500</span>               
                      </pre>
                    </div>
                  </div>
                  <div class="highlight-python3">
                    <div class="highlight">
                      <pre><span></span>
                          <span class="kn">Platform :</span><span class="nn"> RedHat Enterprise Linux</span>
                          <span class="kn">CPU/Memory :</span><span class="nn"> 4 CPU cores/8GB</span>
                          <span class="kn">Database :</span><span class="nn"> RAID10 MySQL InnoDB or PostgreSQL</span>
                          <span class="kn">Monitored hosts :</span><span class="nn"> &gt;1000</span>               
                      </pre>
                    </div>
                  </div>
                  <div class="highlight-python3">
                    <div class="highlight">
                      <pre><span></span>
                          <span class="kn">Platform :</span><span class="nn"> RedHat Enterprise Linux</span>
                          <span class="kn">CPU/Memory :</span><span class="nn"> 8 CPU cores/16GB</span>
                          <span class="kn">Database :</span><span class="nn">Fast RAID10 MySQL InnoDB or PostgreSQL</span>
                          <span class="kn">Monitored hosts :</span><span class="nn"> &gt;10000</span>
                      </pre>
                    </div>
                  </div>
                </div>
          	</section>
          	<section id="demo">
          		<h5 >Supported Platforms</h5><p >Due to security requirements and the mission-critical nature of the monitoring server, UNIX is the only operating system that can consistently deliver the necessary performance, fault tolerance and resilience. Zabbix operates on market-leading versions.</p>
          		<div class="content-switcher setup doc-aside">
          			<ul >
          				<li >Linux</li>
                  		<li>Windows</li>
                  		<li>Mac OS X</li>
                  		<li>FreeBSD</li>
                  		<li>OpenBSD</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span>
                        <span class="kn">Server </span> <span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent </span><span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent 2 </span><span class="nn"><i class="fa fa-check"></i></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span>
                        <span class="kn">Server </span> <span class="nv"><i class="fa fa-times"></i></span>
                        <span class="kn">Agent </span><span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent 2 </span><span class="nn"><i class="fa fa-check"></i></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span>
                        <span class="kn">Server </span> <span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent </span><span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent 2 </span><span class="nv"><i class="fa fa-times"></i></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span>
                        <span class="kn">Server </span> <span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent </span><span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent 2 </span><span class="nv"><i class="fa fa-times"></i></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span>
                        <span class="kn">Server </span> <span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent </span><span class="nn"><i class="fa fa-check"></i></span>
                        <span class="kn">Agent 2 </span><span class="nv"><i class="fa fa-times"></i></span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<div role="alert" class="alert alert-info">
          			<p>Zabbix server/agent may work on other Unix-like operating systems as well. Zabbix agent is supported on all Windows desktop and server versions since XP.</p>
          		</div>
          	</section>
          	<section id="logging-in">
          		<h4 >Software Requirements</h4><p >Zabbix is built around modern web servers, leading database engines, and PHP scripting language.</p>
          		<div class="content-switcher setup doc-aside">
          			<ul >
          				<li>Database</li>
          				<li>Frontend</li>
          				<li>Web Browser</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span>
                        <span class="kn">MySQL</span> 
                        <span class="nn">Version: 5.5.62-8.0.x</span>
                        <span class="kn">PostgreSQL</span> 
                        <span class="nn">Version: 9.2.24 or later</span>
                        <span class="kn">SQLite</span> 
                        <span class="nn">Version: 3.3.5 or later</span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span>
                        <span class="kn">Apache</span> 
                        <span class="nn">Version: 1.3.12 or later</span>
                        <span class="kn">PHP</span> 
                        <span class="nn">Version: 7.2.0 or later</span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span>
                          <span class="kn">Latest versions of</span> <span class="nn">Google Chrome, Mozilla Firefox, Microsoft Edge, 
                          Apple Safari and Opera</span><span class="kn"> are supported</span> 
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<div role="alert" class="alert alert-info">
          			<p>Zabbix may work on previous versions of Apache, MySQL, Oracle, and PostgreSQL as well.</p>
          		</div>
          		<h5>Time Synchronization</h5>
          		<p>It is very important to have precise system tine on server with Zabbix running. It's strongly recommended to maintain synchronised system time on all systems Zabbix components are running on.</p>
          </section>
          <section id="list-records"><h3 >Install from Packages</h3><p >Packages are available with MySQL database and Apache webserver support.</p><p >Official Zabbix packages are available for: </p>
          	<div class="content-switcher setup doc-aside">
          			<ul >
          				<li>Red Hat Enterprise Linux</li>
          				<li>CentOS</li>
          				<li>Oracle Linux</li>
          				<li>Ubuntu</li>
          				<li>Debian</li>
          				<li>SUSE Linux</li>
          				<li>Raspbian</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="kn">OS Version: 8</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/rhel/8/x86_64/zabbix-release-5.0-1.el8.noarch.rpm">Right click and copy link</a></span>
                        <span class="kn">OS Version: 7</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/rhel/7/x86_64/zabbix-release-5.0-1.el7.noarch.rpm">Right click and copy link</a></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="kn">OS Version: 8</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/rhel/8/x86_64/zabbix-release-5.0-1.el8.noarch.rpm">Right click and copy link</a></span>
                        <span class="kn">OS Version: 7</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/rhel/7/x86_64/zabbix-release-5.0-1.el7.noarch.rpm">Right click and copy link</a></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="kn">OS Version: 8</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/rhel/8/x86_64/zabbix-release-5.0-1.el8.noarch.rpm">Right click and copy link</a></span>
                        <span class="kn">OS Version: 7</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/rhel/7/x86_64/zabbix-release-5.0-1.el7.noarch.rpm">Right click and copy link</a></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="kn">20.04 (Focal)</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/ubuntu/pool/main/z/zabbix-release/zabbix-release_5.0-1+focal_all.deb">Right click and copy link</a></span>
                        <span class="kn">18.04 (Bionic)</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/ubuntu/pool/main/z/zabbix-release/zabbix-release_5.0-1+bionic_all.deb">Right click and copy link</a></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="kn">10 (Buster)</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/debian/pool/main/z/zabbix-release/zabbix-release_5.0-1+buster_all.deb">Right click and copy link</a></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="kn">15</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/sles/15/x86_64/zabbix-release-5.0-1.el15.noarch.rpm">Right click and copy link</a></span>
                        <span class="kn">12</span>
                        <span><a href="https://repo.zabbix.com/zabbix/5.0/sles/12/x86_64/zabbix-release-5.0-1.el12.noarch.rpm">Right click and copy link</a></span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                          <span></span>
                          <span class="kn">10 (Buster)</span>
                          <span><a href="https://repo.zabbix.com/zabbix/5.0/raspbian/pool/main/z/zabbix-release/zabbix-release_5.0-1+buster_all.deb">Right click and copy link</a></span>
                          <span class="kn">9 (Stretch)</span>
                          <span><a href="https://repo.zabbix.com/zabbix/5.0/raspbian/pool/main/z/zabbix-release/zabbix-release_5.0-1+stretch_all.deb">Right click and copy link</a></span>
          						</pre>
          					</div>
          			</div>
          		</div>
          </section>
          <section id="pagination"><h3 >Install Zabbix Repository</h3><p >Download the zabbix repository by opening the terminal window and running following commands:</p>
          		<div class="content-switcher setup doc-aside">
          			<ul >
          				<li>Red Hat Enterprise Linux</li>
          				<li>CentOS</li>
          				<li>Oracle Linux</li>
          				<li>Ubuntu</li>
          				<li>Debian</li>
          				<li>SUSE Linux</li>
          				<li>Raspbian</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 8</span>
                        <span class="kn">rpm -Uvh </span><span class="nn">paste the repository link</span>
                        <span class="kn">dnf clean all </span>
                        <span class="nv">OS Version: 7</span>
                        <span class="kn">rpm -Uvh </span><span class="nn">paste the repository link</span>
                        <span class="kn">yum clean all </span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 8</span>
                        <span class="kn">rpm -Uvh </span><span class="nn">paste the repository link</span>
                        <span class="kn">dnf clean all </span>
                        <span class="nv">OS Version: 7</span>
                        <span class="kn">rpm -Uvh </span><span class="nn">paste the repository link</span>
                        <span class="kn">yum clean all </span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 8</span>
                        <span class="kn">rpm -Uvh </span><span class="nn">paste the repository link</span>
                        <span class="kn">dnf clean all </span>
                        <span class="nv">OS Version: 7</span>
                        <span class="kn">rpm -Uvh </span><span class="nn">paste the repository link</span>
                        <span class="kn">yum clean all </span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 20.04 (Focal)</span>
                        <span class="kn">wget </span><span class="nn">paste the repository link</span>
                        <span class="kn">dpkg -i </span><span class="nn">zabbix-release_5.0-1+focal_all.deb</span>
                        <span class="kn">apt update</span>
                        <span class="nv">OS Version: 18.04 (Bionic)</span>
                        <span class="kn">wget </span><span class="nn">paste the repository link</span>
                        <span class="kn">dpkg -i </span><span class="nn">zabbix-release_5.0-1+focal_all.deb</span>
                        <span class="kn">apt update</span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 10 (Buster)</span>
                        <span class="kn">wget </span><span class="nn">paste the repository link</span>
                        <span class="kn">dpkg -i </span><span class="nn">zabbix-release_5.0-1+focal_all.deb</span>
                        <span class="kn">apt update</span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 15</span>
                        <span class="kn">rpm -Uvh --nosignature </span><span class="nn">paste the repository link</span>
                        <span class="kn">zypper --gpg-auto-import-keys refresh </span><span class="nn">'Zabbix Official Repository'</span>
                        <span class="nv">OS Version: 12</span>
                        <span class="kn">rpm -Uvh --nosignature </span><span class="nn">paste the repository link</span>
                        <span class="kn">zypper --gpg-auto-import-keys refresh </span><span class="nn">'Zabbix Official Repository'</span>
          							</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 10 (Buster)</span>
                        <span class="kn">wget </span><span class="nn">paste the repository link</span>
                        <span class="kn">dpkg -i </span><span class="nn">zabbix-release_5.0-1+buster_all.deb</span>
                        <span class="kn">apt update</span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          </section>
          <section id="count-records"><h3 >Install Zabbix server,frontend and agent</h3><p >After the zabbix repository is downloaded, install zabbix server, frontend and agent by running the following commands:</p>
          	<div class="content-switcher setup doc-aside">
          		<ul >
          			<li>Red Hat Enterprise Linux</li>
          			<li>CentOS</li>
          			<li>Oracle Linux</li>
          			<li>Ubuntu</li>
          			<li>Debian</li>
          			<li>SUSE Linux</li>
          			<li>Raspbian</li>
          		</ul>
          		<div class="tabs">
          			<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 8</span>
                        <span class="kn">dnf install </span><span class="nn">zabbix-server-mysql zabbix-web-mysql zabbix-apache-conf zabbix-agent</span>
                        <span class="nv">OS Version: 7</span>
                        <span class="kn">yum install </span><span class="nn">zabbix-server-mysql zabbix-agent</span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 8</span>
                        <span class="kn">dnf install </span><span class="nn">zabbix-server-mysql zabbix-web-mysql zabbix-apache-conf zabbix-agent</span>
                        <span class="nv">OS Version: 7</span>
                        <span class="kn">yum install </span><span class="nn">zabbix-server-mysql zabbix-agent</span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 8</span>
                        <span class="kn">dnf install </span><span class="nn">zabbix-server-mysql zabbix-web-mysql zabbix-apache-conf zabbix-agent</span>
                        <span class="nv">OS Version: 7</span>
                        <span class="kn">yum install </span><span class="nn">zabbix-server-mysql zabbix-agent</span>
           						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 20..04 (Focal) and 18.04 (Bionic)</span>
                        <span class="kn">apt install </span><span class="nn">zabbix-server-mysql zabbix-frontend-php zabbix-apache-conf zabbix-agent</span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                        <span></span>
                        <span class="nv">OS Version: 10 (Buster)</span>
                        <span class="kn">apt install </span><span class="nn">zabbix-server-mysql zabbix-frontend-php zabbix-apache-conf zabbix-agent</span>
          						</pre>
          					</div>
          				</div>
          				 <div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                          <span></span>
                          <span class="nv">OS Version: 15</span>
                          <span class="kn">SUSEConnect -p </span><span class="nn">sle-module-web-scripting/15/x86_64</span>
                          <span class="nv">OS Version: 12</span>
                          <span class="kn">SUSEConnect -p </span><span class="nn">sle-module-web-scripting/12/x86_64</span>
          						</pre>
          					</div>
          				</div>
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
                          <span></span>
                          <span class="nv">OS Version: 10 (Buster)</span>
                          <span class="kn">apt install </span><span class="nn">zabbix-server-mysql zabbix-frontend-php zabbix-apache-conf zabbix-agent</span>
          						</pre>
          					</div>
          				</div>
          		</div>
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
  </footer>
</html>
