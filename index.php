<!DOCTYPE html>

<head>
<link rel="stylesheet" type="text/css" href="basic.css">
<title>CS 455 Project</title>
</head>


<img src="images/ben_thomas_accession_3.png"/>

<div>
  <h2>
    <a href = "timber.php">Project 4: Timber</a>
  </h2>
</div>

<div>
  <h2>
    <a href = "proposal.html">Project 3 Proposal Page</a>
  </h2>
</div>


<div>
  <h2>
    Project 2 Directory
  </h2>
</div>

<div align="left">
  <ol>
    <li>
      <a href = "showPassengers.php">Passenger List</a>
    </li>
    <li>
      <a href = "passenger_form.php">Create Passenger</a>
    </li>
    <li>
      <a href = "arbitraryQuery.php">SQL Query</a>
    </li>
  </ol>
</div>

<div>
  <h2>
    Project 1 Answers
  </h2>
</div>

<div align="left">
  <ol>
    <li>
      The following code will display all apache processes running:
      </br><code>ps -aux |grep apache</code>
    </li>
    <li>
      GET retrieves the information identified by the Request-URI.<br/>
      HEAD does the same thing as get except it doesn't return a message-body.</br>
      POST requests that the server accept whatever is in the request as a subordinate of the resource identified by the Request-URI.
    </li>
    <li>
      ServerRoot is the path to the directory where the config, error and log files are kept.<br/>
      DocumentRoot is the path to the files delivered by the server.
    </li>
    <li>
      The port is port 80.
    </li>
    <li>
      We need to place all of our HTML and PHP documents in <code>/var/www/html/</code> to serve them up
    </li>
    <li>
      All apache logs are located in <code>/var/log/apache2</code>. The error logs are in a file called <code>error.log</code>, the traffic logs are in <code>access.log</code>.
    </li>
    <li>
      When a request is made to a URL that points to a directory instead of an actual file within a directory, web servers will either serve the Directory Index file or serve a default index file. It would be nice to have one in each directory so that you don't just get the default version which is probably unhelpful.
    </li>
    <li>
      Use this command <code>sudo a2enmod userdir</code>, then restart the server.
    </li>
    <li>
      Use the <code>htpasswd</code> utility to create a file that stores usernames and passwords, then create a <code>.htaccess</code> file in the directory you want to protect that references the password file.
      Note that for this to work, <code>AllowOverride</code> must be changed to 'All' in the <code>Directory</code> block in the main configuration file.
    </li>
    <li>
      Insert the following line into the config file:<br/>
        <code>ErrorDocument 404 http://54.173.137.240:80</code><br/>.
        This performs an action after the 404 error, which in this case is a redirect to the given URL.
    </li>
  </ol>
</div>
