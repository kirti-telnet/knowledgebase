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
    <script type="text/javascript" src="../_static/documentation_options.js"></script>
    <script type="text/javascript" src="../_static/jquery.js"></script>
    <script type="text/javascript" src="../_static/underscore.js"></script>
    <script type="text/javascript" src="../_static/doctools.js"></script>
    <script type="text/javascript" src="../_static/jquery.min.js"></script>
    <script type="text/javascript" src="../_static/bootstrap.js"></script>
    <script type="text/javascript" src="../_static/doc.js"></script>
    <script type="text/javascript" src="../_static/jquery.noconflict.js"></script>
    <script type="text/javascript" src="../_static/patchqueue.js"></script><link rel="canonical" href="odoo.html" />
</head>
<body>
  <header>
    <?php
       include('header.php');
    ?>
  </header>
  <div id="wrap" class="has_code_col">
    <figure class="card top has_banner">
      <span class="card-img" style="background-image: url('../_static/banners/web_service_api.jpg');"></span>
      <div class="container text-center">
        <h1> Syslog-ng with MySQL </h1>
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
          		<p >Syslog-ng is a centralized log management system. With syslog-ng, you can collect logs from any source, process them in real time and deliver them to a wide variety of destinations. It allows you to flexibly collect, parse, classify, rewrite and correlate logs from across your infrastructure and store or route them to log analysis tools.</p><p>The logs being generated by syslog-ng can be imported to a database for easier viewing and analysis</p>
          	</section>
          	<section id="connection">
          		<h2 >Installation</h2>
          	</section>
          	<section id="configuration">
          		<h3 >Requirements</h3><p>For installation of syslog-ng you require an Linux operating system.</p>
          		<div role="alert" class="alert alert-info">
          			<h3 class="alert-title">Information</h3><p>Here the demonstration will be on Ubuntu Server 18.04.A MySQL database is required to import the syslog-ng logs. The MySQL package can be downloaded from the website <a href="https://www.mysql.com">https://www.mysql.com</a>. Here MySQL is installed and configured on the syslog-ng server.</p>
          		</div>
          		<p>Two Systems need to confiured for syslog-ng: 
          			<li>The first system will serve as a syslog-ng log collector</li>
          			<li>The second system will serve as a client sending log files to the collector</li>
          			<div role="alert" class="alert alert-info"><h3 class="alert-title">Information</h3>
          				<p>
          					In this demonstration the client system is also using Ubuntu Server 18.04 operating system.
          				</p>
          			</div>
          		</p>
          	</section>
          	<section id="demo">
          		<h3 >Syslog-ng Installation</h3><p >The installation is simple. Installation will be from the standard repositories, in order to make this as easy as possible. To do this, open up a terminal window and issue the command:</p>
          		<div class="content-switcher setup doc-aside">
          			<ul >
          				<li >Linux</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span><span class="kn">sudo apt install</span> <span class="nn">syslog-ng</span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<p>You must issue the command on both collector and client. Once that's installed, you're ready to configure.</p>
          	</section>
          	<section id="logging-in">
          		<h3 >Configuring Syslog-ng Collector</h3><p >The configuration file is <code>/etc/syslog-ng/syslog-ng.conf</code>Rename the default config file with the command: </p>
          		<div class="content-switcher setup doc-aside">
          			<ul >
          				<li >Linux</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span><span class="kn">sudo mv</span> <span class="nn">/etc/syslog-ng/syslog-ng.conf /etc/syslog-ng/syslog-ng.conf.BAK</span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<p>Now create a new configuration file with the command:</p>
          		<div class="content-switcher setup doc-aside">
          			<ul >
          				<li >Linux</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre><span></span><span class="kn">sudo nano</span> <span class="nn">/etc/syslog-ng/syslog-ng.conf</span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<p>In that file add the following:</p>
          		<div class="content-switcher setup doc-aside">
          			<ul >
          				<li >Linux</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
          							<span class="nv">
@version: 3.13
@include "scl.conf"
@include "`scl-root`/system/tty10.conf"
########################################
options {
     time-reap(30);
     mark-freq(10);
     keep-hostname(yes);
};
#########################################
source s_local { system(); internal(); };
source s_network {
        syslog(transport(tcp) port(514));
};
##########################################
destination d_mysql {
	pipe("/tmp/mysql.pipe"
    	template("INSERT INTO logs (Host, datetime,program, msg) 
    	VALUES('$HOST','$YEAR-$MONTH-$DAY-$HOUR:$MIN:$SEC','$PROGRAM','$MSG');\n")
    	template-escape(yes));
};
############################################
log { source(s_local); source(s_network); destination(d_mysql); };
          							</span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<div role="alert" class="alert alert-warning">
          			<h3 class="alert-title">Warning</h3><p>Do note that we are working with port 514, so you'll need to make sure it is accessible on your network.</p>
          		</div>
          		<p>Save and close the file. The above configuration will dump the desired log files into the table that is created in MySql</p>
          	</section>
          <section id="calling-methods">
          	<h3 >Configuring Syslog-ng Client</h3><p >The same thing needs to be followed on the client (moving the default configuration file and creating a new configuration file).</p><p >Copy the following text into the new client configuration file:</p>
          	<div class="content-switcher setup doc-aside">
          			<ul >
          				<li >Linux</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
          							<span class="nv">
@version: 3.13
@include "scl.conf"
@include "`scl-root`/system/tty10.conf"
#######################################
source s_local { system(); internal(); };

destination d_syslog_tcp {
              syslog("x.x.x.x" transport("tcp") port(514)); 
          };

log { source(s_local);destination(d_syslog_tcp); };
          							</span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<div role="alert" class="alert alert-warning">
          			<h3 class="alert-title">Warning</h3><p>Change "x.x.x.x" with the IP address of syslog-ng server</p>
          		</div>
          </section>
          <section id="list-records"><h3 >MySQL Database</h3><p >A database for syslog-ng is required to be created with appropriate table and fields.</p><p >This is done by the following commands:</p>
          	<div class="content-switcher setup doc-aside">
          			<ul >
          				<li >Linux</li>
          			</ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
<span></span><span class="kn">CREATE DATABASE</span> <span class="nn">syslog;</span>
<span class="kn">CREATE USER</span><span class="nn"> {username}@localhost</span><span class="kn"> IDENTIFIED BY </span><span class="nn">{password};</span>
<span class="kn">CREATE TABLE</span><span class="nn"> `logs` (`Host` varchar(32) DEFAULT NULL,`datetime` datetime DEFAULT NULL,`program` varchar(100) DEFAULT NULL,`msg` text,`seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,PRIMARY KEY (`seq`),KEY `host` (`host`),KEY `program` (`program`),KEY `datetime` (`datetime`));</span>
          						</pre>
          						<pre></pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<div role="alert" class="alert alert-warning">
          			<h3 class="alert-title">Warning</h3><p>Change "x.x.x.x" with the IP address of syslog-ng server</p>
          		</div>
          </section>
          <section id="pagination"><h3 >Bash Script</h3><p >Bash script is required to create a pipe betwwen the syslog-ng server and MySQL.</p><p>Create a file name mysql-2-syslog.sh and make sure its start with system startup</p>
          		<div class="content-switcher setup doc-aside"><ul ><li >Linux</li></ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
<span></span><span class="kn">sudo mkdir </span><span class="nn">/temp</span>
<span class="kn">sudo touch </span><span class="nn">/temp/mysql-2-syslog.sh</span>
<span class="kn">sudo chmod +x </span><span class="nn">/temp/mysql-2-syslog.sh</span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<p>Edit the file and paste the following in the file: </p>
          		<div class="content-switcher setup doc-aside"><ul ><li >Linux</li></ul>
          			<div class="tabs">
          				<div class="highlight-python3">
          					<div class="highlight">
          						<pre>
<span class="kn">nano </span><span class="nn">/temp/mysql-2-syslog.sh</span>
<span class="nv"> 
SQLID="username"
SQLPASS="password"
export MYSQL_PWD=$SQLPASS
if [ ! -e /tmp/mysql.pipe ]
then
	mkfifo /tmp/mysql.pipe
fi
while [ -e /tmp/mysql.pipe ]
do
	mysql -u$SQLID syslog &lt;/tmp/mysql.pipe &gt;/dev/null
done
</span>
          						</pre>
          					</div>
          				</div>
          			</div>
          		</div>
          		<div role="alert" class="alert alert-warning">
          			<h3 class="alert-title">Warning</h3><p>Change "username" and "password" with your MySQL database username and password </p>
          		</div>
          </section>
          <section id="count-records"><h3 >Enable Services And Script</h3><p >The syslog-ng services need to be started and enabled. Also the bash script must run in the backgroud</p>
          	<p>Open the terminal window and enter the following commands:</p>
          	<div class="content-switcher setup doc-aside">
          		<ul ><li >Linux</li></ul>
          		<div class="tabs">
          			<div class="highlight-python3">
          				<div class="highlight">
          					<pre>
          						<span></span>
<span class="kn">sudo</span><span class="nn"> /temp/mysql-2-syslog.sh &</span>
<span class="kn">sudo systemctl start </span><span class="nn">syslog-ng</span>
<span class="kn">sudo systemctl enable </span><span class="nn">syslog-ng</span>
          					</pre>
          				</div>
          			</div>
          		</div>
          	</div>
          </section>
          <section id="read-records"><h2 >Output</h2>
          	<p >Login into your MySQL and check the database. The logs will be stored in the table mentioned in the configuration file of syslog-ng server.</p>
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
<!-- Mirrored from www.odoo.com/documentation/13.0/webservices/odoo.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Aug 2020 10:07:38 GMT -->
</html>