<!DOCTYPE html>
<html>
<head>
<title>Gawesh's Demo of PHP Frontend connection to IBM Cloud DB2</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
$database = "BLUDB"; # Replace the ??? based on the information in your Service details from IBM
Cloud web console
$hostname = "dashdb-txn-sbox-yp-lon02-02.services.eu-gb.bluemix.net";
$user = "zgh79455"; #
$password = "79rf3rmc+9cg8rk2"; #
$port = "50000"; #
$ssl_port = "50001"; #
# Build the connection string
$driver = "DRIVER={IBM DB2 ODBC DRIVER};";
$dsn = "DATABASE=$database; " .
"HOSTNAME=$hostname;" .
"PORT=$port; " .
"PROTOCOL=TCPIP; " .
"UID=$user;" .
"PWD=$password;";
#$ssl_dsn = "DATABASE=$database; " .
# "HOSTNAME=$hostname;" .
# "PORT=$ssl_port; " .
# "PROTOCOL=TCPIP; " .
# "UID=$user;" .
# "PWD=$password;" .
# "SECURITY=SSL;";
$conn_string = $driver . $dsn; # Non-SSL
#$conn_string = $driver . $ssl_dsn; # SSL - we don't need SSL in this project
# Connect
#
$conn = odbc_connect( $conn_string, "", "" );
if( $conn )
{
echo "<p>Successful Connection</p>";
# Query the database
$sql = "SELECT NAME, LOCATION FROM LOCATIONS";

# Execute the query
$result=odbc_exec($conn, $sql);

# Process the result of the query
# The result is made up of several rows made up to the location and temperature values
while(odbc_fetch_row($result)) // Fetch each row of the result
{
// Access the value of each field using the function odbc_result
echo "<p>location: " . odbc_result($result, "LOCATION") . " - Name: " . odbc_result($result,
"NAME") . "</p>";
}
odbc_close( $conn );
}
else
{
echo "<p>Failed Connection</p>";
}
?>
</body>
</html>