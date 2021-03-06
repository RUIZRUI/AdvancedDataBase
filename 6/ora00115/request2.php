<?php
/**************************************************************************
*       Author: Paul Girard, Ph.D., UQAC
*       Date:   March 2013
*       Course: 8trd157
*       Objective: Show an example of SQL request activated by an html page 
*               on the table part of a user schema defined in database 11g cndb
***************************************************************************     
*       1. Creation of a connection identifier in the user schema to the Oracle 11g
*          database. OCIError returns false if there is a connection error.
*          The function header with the parameter Location can REDIRECT the execution to 
*          another html page. 
*/
$bd = 'localhost/CNDB';
$connection = OCI_connect('ora00115', 'UdfP94', $bd);
if(!$connection) 
        {
        $url = "connection_error.html";
        header("Location: $url");
        exit;
        };

/*      The complete content of the result is formatted in html by the concatenation
*       of all information in the string variable $chaine0.  If we use echo, the redirect
*       is no more possible.  So echo is used only at the end. The header function
*       specifies a new HTTP header to use a redirect and this header must be sent before
*       any data to the client with echo. The final string is sent to Apache which will *	*	*		transmit it to the HTTP client.
*/

$chain = "<HTML><HEAD><TITLE>Request SQL</TITLE></HEAD><body>\n";
$chain .= "<P align = \"left\"><font size=4> A form on an html page calls a PHP program executing an&nbsp"; 
$chain .= "SQL request to an Oracle server. The PHP output is sent to Apache like a CGI program.  Apache &nbsp";
$chain .= "redirects this output to the HTTP client <i>(ex. Internet Explorer)</i> which displays the result\n";
$chain .= "</font><br><br>\n";
$chain .= "<center><b><font size=+3>Result of the SQL request</font></b></center>\n";

/* Activation of the external form variable (partid) used by POST 
==>isset()	returns TRUE if var or partid (or list of variables exists and has any value				other than NULL
=>empty()	Determine whether a variable is empty
=>$_REQUEST	This is an HTTP Request variables and can be used with both the GET and POST				methods it collects the data passed from a form
*/


if( isset($_REQUEST['num']) && !empty($_REQUEST['num']))
{
	$num = $_REQUEST['num'];
}

$curs1 = OCI_parse($connection, "select p.supplier_id as a, p.product_id as b, p.unit as c, p.unit_price as d from pot_supplier pot, product p where pot.part_id='$num' and pot.product_id=p.product_id");

if(OCI_Error($curs1))
        {
        OCI_close($connection);
        $url = "err_base.html";
        header("Location: $url");
        exit;
        };

/*      3. Assign Oracle table columns names to PHP variables
*          note 1: The definition of these columns must always be done before an execution; 
*          note 2: Oracle always uses capital letters for the columns of a table
*/
OCI_Define_By_Name($curs1,"A",$supplier_id);
OCI_Define_By_Name($curs1,"B",$product_id);
OCI_Define_By_Name($curs1,"C",$unit);
OCI_Define_By_Name($curs1,"D",$unit_price);

/*      4. Execution of the SQL request with an immediate commit to free locks */
OCI_Execute($curs1, OCI_COMMIT_ON_SUCCESS);
$chain .= "<b>supplier_id  product_id unit  unit_price</b><br>\n";

/*      5. Read each row from the result of the Sql request */  
while (OCI_fetch($curs1))
        $chain .= "$supplier_id  &nbsp &nbsp &nbsp &nbsp &nbsp $product_id &nbsp &nbsp &nbsp &nbsp &nbsp $unit &nbsp &nbsp &nbsp &nbsp &nbsp $unit_price<br>\n";

/*      6. Terminate the end of the html format page */
$chain .= "</body></html>\n";
print "<b>Version of this server :</b> " . OCIServerVersion($connection);
/*      7. Free all ressources used by this command and quit */
OCI_Free_Statement($curs1);
OCI_close($connection);

/*      8. Transmission of the html page ==> Apache ==> client */
echo($chain);
?>
