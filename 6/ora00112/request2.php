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
$connection = OCI_connect('ora00112', '5VHbXr', $bd);
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


if( isset($_REQUEST['ponumber']) && !empty($_REQUEST['ponumber']))
{
	$ponumber = $_REQUEST['ponumber'];
}

$curs1 = OCI_parse($connection, "select po.po_number as a, po.po_date as b, pa.pa_name as c, s.supplier_id as d, s.supplier_name as e, s.addr as f, s.contact as g, p.product_id as h, p.product_name as i, p.unit as j, p.unit_price as k, d.qty_order as l, d.qty_rec as m from purchase_order po, contractual c, pa_task pt, pa_agent pa, supplier s, detail d, product p where po.po_number='$ponumber' and c.po_number='$ponumber' and pt.po_number='$ponumber' and pa.emp_num=pt.emp_num and s.supplier_id=c.supplier_id and d.po_number='$ponumber' and d.product_id=p.product_id");

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
OCI_Define_By_Name($curs1,"A",$po_number);
OCI_Define_By_Name($curs1,"B",$po_date);
OCI_Define_By_Name($curs1,"C",$pa_name);
OCI_Define_By_Name($curs1,"D",$supplier_id);
OCI_Define_By_Name($curs1,"E",$supplier_name);
OCI_Define_By_Name($curs1,"F",$addr);
OCI_Define_By_Name($curs1,"G",$contact);
OCI_Define_By_Name($curs1,"H",$product_id);
OCI_Define_By_Name($curs1,"I",$product_name);
OCI_Define_By_Name($curs1,"J",$unit);
OCI_Define_By_Name($curs1,"K",$unit_price);
OCI_Define_By_Name($curs1,"L",$qty_order);
OCI_Define_By_Name($curs1,"M",$qty_rec);


/*      4. Execution of the SQL request with an immediate commit to free locks */
OCI_Execute($curs1, OCI_COMMIT_ON_SUCCESS);
$chain .= "<b>po_number  po_date pa_name supplier_id supplier_name addr contact product_id product_name unit unit_price  qty_order qty_rec</b><br>\n";

/*      5. Read each row from the result of the Sql request */  
while (OCI_fetch($curs1))
        $chain .= "$po_number  &nbsp &nbsp &nbsp &nbsp &nbsp $po_date &nbsp &nbsp &nbsp &nbsp &nbsp $pa_name &nbsp &nbsp &nbsp &nbsp &nbsp $supplier_id &nbsp &nbsp &nbsp &nbsp &nbsp $supplier_name&nbsp &nbsp &nbsp &nbsp &nbsp $addr &nbsp &nbsp &nbsp &nbsp &nbsp$contact&nbsp &nbsp &nbsp &nbsp &nbsp $product_id &nbsp &nbsp &nbsp &nbsp &nbsp$product_name&nbsp &nbsp &nbsp &nbsp &nbsp $unit &nbsp &nbsp &nbsp &nbsp &nbsp$unit_price &nbsp &nbsp &nbsp &nbsp &nbsp$qty_order &nbsp &nbsp &nbsp &nbsp &nbsp$qty_rec<br>\n";

/*      6. Terminate the end of the html format page */
$chain .= "</body></html>\n";
print "<b>Version of this server :</b> " . OCIServerVersion($connection);
/*      7. Free all ressources used by this command and quit */
OCI_Free_Statement($curs1);
OCI_close($connection);

/*      8. Transmission of the html page ==> Apache ==> client */
echo($chain);
?>
