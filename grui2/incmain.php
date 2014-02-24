<?php

$qe = '';
$messagez = '';
$title1 = '';

if (isset($_GET['qe']))
{	$qe = $_GET['qe'];	}
else
{	$qe = "blank";	}

if( $qe == "blank" )
{
	$title1 = "now";
	$messagez = "
	<h2>rinc</h2>
	<p>
	On this website products can be created and traded.
	</p>
	source : <a href=https://github.com/thename151/tablesalt>github.com/thename151/tablesalt</a><br>
	";
}


if( $qe == "scores" )
{
	$title1 = "show scores";
	include_once '../funcss/showscores.php';

	$mess1 = showscores($name1);
	$mess2 = "";

	for( $i2 = 0; $i2 < sizeof($mess1); $i2++ )
	{
		$mess3f = "";
		$mess2f = "";
		
		if( $mess1[$i2][3] < 0 )
		{
			$mess3f = (float)$mess1[$i2][3];
		} 
		if( $mess1[$i2][2] != 0 )
		{
			$mess2f = (float)$mess1[$i2][2];
		}
		if( $mess1[$i2][3] == "zero" )
		{
			$mess3f = "0";
		}

		$mess2 .= '<tr><td><a href="page.php?qe=user&cr1=' . $mess1[$i2][0] . '">'.$mess1[$i2][0].' </a> </td>';
		$mess2 .= '<td> <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][0] . '			
				&pr1=' . $mess1[$i2][1] . '"">' . $mess1[$i2][1] . '</a> </td>';
		$mess2 .= "<td>" . $mess2f . "</td>";
		$mess2 .= "<td><center>" . $mess3f . "</center></td></tr>";
		
	}
	$mess2 = "<center><table>" . $mess2 . "</table></center>";

	if( sizeof($mess1)== 0 )
	{
		$mess2 = "no score";
	}
	else 
	{
		$mess2 = "<center><table>" . $mess2 . "</table></center>";
	}
	
	$messagez = $mess2;
}


if( $qe == "prices" )
{
	$title1 = "list prices";
	include '../funcss/listtrades2.php';

	$startfrom = '';
	$results = '';
	$cr1 = '';
	$pr1 = '';
	$cr2 = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
	if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}
	if (isset($_GET['cr2'])){ $cr2 = $_GET['cr2'];}else{$cr2 = "";}

	$mess1 = "";

	if(( $cr1 != "") && ($pr1 != "") )
	{
		$mess1 = listtrades46($startfrom, $results, $cr1, $pr1 );
		$title1 = "list $cr1 $pr1 prices";
	}
	else
	{
		if( $cr2 != "" )
		{	
			$mess1 = listtrades64($startfrom, $results, $cr2 );
			$title1 = "list $cr2 prices";
		}
		else
		{
			$mess1 = listtrades23($startfrom, $results);
		}
	}

	$mess2a = "";
	$mess4 = "page.php?qe=prices&";

	include_once( "incs3.php" );

	$mess2 = $displayResults . "<br>";
	$th1 = '';

	$sz = sizeof($mess1);
	if ( $sz < 2 )
	{
		$mess2a =  "no prices";
		$sz = -1;
	}
	else
	{
		$th1 = '
			<tr><td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>bid</td>
			<td>ask</td></tr>';
	}

	$x1 = $startfrom;
	$mess2 .= $mess1[0][0];

	for( $i2 = 1; $i2 < $sz; $i2++ )
	{
		$mess2a .= '<tr><td><a href="page.php?qe=user&cr1=' . $mess1[$i2][0] . '">'.$mess1[$i2][0].' </a> </td>';
		$mess2a .= '<td> <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][0] . '			
				&pr1=' . $mess1[$i2][1] . '">' . $mess1[$i2][1] . '</a> </td>';
		$mess2a .= '<td> <a href="page.php?qe=market
				&cr1=' . $mess1[$i2][0] . '			
				&pr1=' . $mess1[$i2][1] . '			
				&cr2=' . $mess1[$i2][2] . '			
				&pr2=' . $mess1[$i2][3] . '">_/&#175</a> </td>';

		$mess2a .= '<td><a href="page.php?qe=user&cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a> </td>';		
		$mess2a .= '<td> <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][2] . '			
				&pr1=' . $mess1[$i2][3] . '">' . $mess1[$i2][3] . '</a> </td>';

		if( $mess1[$i2][6] == 0 )
		{
			$mess2a .= '<td>' . $mess1[$i2][4] . '</td>';
			$mess2a .= '<td>' . $mess1[$i2][5] . '</td>';
		}
		else
		{
			$mess2a .= '<td> <a href="page.php?qe=settrade1&am1=' . $mess1[$i2][4] . '
				&type1=sell
				&cr1=' . $mess1[$i2][0] . '
				&pr1=' . $mess1[$i2][1] . '
				&cr2=' . $mess1[$i2][2] . '
				&pr2=' . $mess1[$i2][3] . '"
				> ' . $mess1[$i2][4] . '</a>  </td>';
		
			$mess2a .= '<td> <a href="page.php?qe=settrade1&am1=' . $mess1[$i2][5] . '
				&type1=buy
				&cr1=' . $mess1[$i2][0] . '			
				&pr1=' . $mess1[$i2][1] . '			
				&cr2=' . $mess1[$i2][2] . '			
				&pr2=' . $mess1[$i2][3] . '"			
				> ' . $mess1[$i2][5] . '</a></td>'; //'.$mess1[$i2][6].'
		}		
		$mess2a .= '</tr>';
	}

	$mess2 .= '<table class="blue">' . $th1 . $mess2a . '</table>';
	$mess2 .= "<br>" . $mess3 . "<br>";

	$messagez = $mess2;
}

if( $qe == "myproducts" )
{
	$title1 = "list profile's products";
	include '../funcss/listproducts.php';

	$startfrom = '';
	$results = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}


	$mess1 = listprofilesproducts($name1, $startfrom, $results );
	$mess4 = "page.php?qe=myproducts&";

	include_once( "incs3.php" );

	$mess2 = $displayResults . "<br>";
	$mess2a = "";

	for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
	{
		$mess2a .= "<tr>";
		$mess2a .= "<td><a href='page.php?qe=deleteproduct1&prd1=".$mess1[$i2][2] ."'>delete</a></td>";
		$mess2a .= '<td> <a href="page.php?qe=product
				&cr1=' . $name1 . '			
				&pr1=' . $mess1[$i2][2] . '">' . $mess1[$i2][2] . '</a> </td>';
		$mess2a .= "<td>" . $mess1[$i2][0] . "</td>";
		$mess2a .= "<td>" . $mess1[$i2][1] . "</td>";

		$mess2a .= "<td><a href='page.php?qe=div1&pr1=".$mess1[$i2][2] ."'>pay dividend</a></td>";
		$mess2a .= "<td>" . $mess1[$i2][3] . "</td>";
		$mess2a .= "</tr>";
	}

	$mess2 .= "<center><table border=0>" . $mess2a .  "</table></center>";
	$mess2 .= "<br>" . $mess3 . "<br>";

	$mess2 .= '<br><center><a href="page.php?qe=createproduct1">add product</a></center><br>';
	
	$messagez = $mess2;
}

if( $qe == "mytrades" )
{
	$title1 = "list profile's trades";

	include '../funcss/listtrades.php';

	$mess1 = listprofilestrades($name1);
	$mess2 = "";
	$sizemess = sizeof($mess1);

	for( $i2 = 0; $i2 < $sizemess; $i2++ )
	{
		$mess31 = 1 * $mess1[$i2][2];
		$mess32 = 1 * $mess1[$i2][3];
		$mess4 = $mess1[$i2][0];
		
		$mess2 .= "<tr><td><a href='page.php?qe=deletetrade1&trd1=". $mess4 ."'>delete</a></td>";
		$mess2 .= "<td><a href='page.php?qe=edittrade1&txno=". $mess1[$i2][0] ."'> ". $mess1[$i2][0] . "</a></td>";
		
		$mess2 .= "<td>" . $mess1[$i2][1] . "</td>";
		$mess2 .= "<td>$mess31</td>";

		$mess2 .= '<td><a href="page.php?qe=user&cr1=' . $mess1[$i2][4] . '">'.$mess1[$i2][4].' </a> </td>';
		
		$mess2 .= '<td> <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][4] . '			
				&pr1=' . $mess1[$i2][5] . '"">' . $mess1[$i2][5] . '</a> </td>';
		$mess2 .= "<td>  for  </td>";
		$mess2 .= "<td>$mess32</td>";

		$mess2 .= '<td><a href="page.php?qe=user&cr1=' . $mess1[$i2][6] . '">'.$mess1[$i2][6].' </a> </td>';
		
		$mess2 .= '<td> <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][6] . '			
				&pr1=' . $mess1[$i2][7] . '"">' . $mess1[$i2][7] . '</a> </td>';
	}

	if( $sizemess == 0 )
	{
		$mess2 = "there are no trades";
	}

	$mess2 = "<table>" . $mess2 . "</table>";
	$mess2 .= '<br><center><a href="page.php?qe=settrade1&am1=1&type1=sell&cr1=&pr1=&cr2=&pr2=">add trade</a><br></center><br>';

	$messagez = $mess2;
}


if( $qe == "users" )
{
	$title1 = "users";
	include '../funcss/listusers.php';

	$startfrom = '';
	$results = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}

	$mess1 = listusers2( $startfrom, $results );
	$mess4 = "page.php?qe=users&";
	include_once( "incs3.php" );

	$mess2 = $displayResults . "<br>";

	for( $i2 = 1; $i2 < sizeof( $mess1 ); $i2++ )
	{
		$mess2 .= '<a href="page.php?qe=user&cr1=' . $mess1[$i2] . '">'.$mess1[$i2].' </a><br>';//      $mess1[ $i2 ]. "<br>";
	}
	$mess2 .= "<br>" . $mess3 . "<br>";
	
	$messagez = $mess2;
}

if( $qe == "products" )
{
	$title1 = "products";
	include '../funcss/listproducts.php';

	$startfrom = '';
	$results = '';
	$cr1 = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

	$mess1 = "";

	if( $cr1 != "")
	{
		$mess1 = listproducts2($cr1, $startfrom, $results );
		$title1 = "list $cr1 products";
	}
	else
	{
		$mess1 = listproducts( $startfrom, $results );
	}

	$mess4 = "page.php?qe=products&";

	include_once( "incs3.php" );

	$mess2 = $displayResults . "<br>";
	$mess2a = "";

	for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
	{
		$mess2a .= '<tr><td><a href="page.php?qe=user&cr1=' . $mess1[$i2][4] . '">'.$mess1[$i2][4].' </a> </td>';
		$mess2a .= '<td> <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][4] . '			
				&pr1=' . $mess1[$i2][2] . '"">' . $mess1[$i2][2] . '</a> </td>';
		$mess2a .= "<td>" . $mess1[$i2][0] . "</td>";
		$mess2a .= "<td>" . $mess1[$i2][1] . "</td>";
		$mess2a .= "<td>" . $mess1[$i2][3] . "</td>";

		$mess2a .= "</tr>";
	}

	$mess2 .= "<center><table border=0>" . $mess2a .  "</table></center>";
	$mess2 .= "<br>" . $mess3 . "<br>";
	
	$messagez = $mess2;
}

if( $qe == "dividends" )
{
	$title1 = "dividends";
	include '../funcss/divs.php';

	$startfrom = '';
	$results = '';

	$cr1 = '';
	$pr1 = '';
	$cr2 = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}

	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
	if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}
	if (isset($_GET['cr2'])){ $cr2 = $_GET['cr2'];}else{$cr2 = "";}


	if(( $cr1 != "") && ($pr1 != "") )
	{
		$mess1 = listdivs2( $startfrom, $results, $cr1, $pr1 );
		$title1 = "list $cr1 $pr1 dividends";
	}
	else
	{
		if( $cr2 != "" )
		{	
			$mess1 = listdivs3( $startfrom, $results, $cr2 );
			$title1 = "list $cr2 dividends";
		}
		else
		{
			$mess1 = listdivs( $startfrom, $results );
		}
	}

	$mess4 = "page.php?qe=dividends&";

	include_once( "incs3.php" );

	$mess2 = $displayResults . "<br>";

	$mess2a = "";

	for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
	{
		$var1 = $mess1[$i2][4] * 1;
		$mess2a .= "<tr><td>" . $var1 . "</td>";

		$mess2a .= '<td><a href="page.php?qe=user&cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a></td>';
		$mess2a .= '<td>
		 <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][2] . '			
				&pr1=' . $mess1[$i2][3] . '"">' . $mess1[$i2][3] . '</a> 
		</td>';
		$mess2a .= '<td> to each </a> </td>';

		$mess2a .= '<td><a href="page.php?qe=user&cr1=' . $mess1[$i2][0] . '">'.$mess1[$i2][0].' </a></td>';
		$mess2a .= '<td>
		 <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][0] . '			
				&pr1=' . $mess1[$i2][1] . '"">' . $mess1[$i2][1] . '</a> 
		</td>';
		
		$mess2a .= '<td>'.$mess1[$i2][5].' </a> </td>';
		
		$mess2a .= "<td>" . $mess1[$i2][6] . "</td></tr>";
	}

	$mess2 .= "<table>" . $mess2a . "</table>";
	$mess2 .= "<br>" . $mess3 . "<br>";
	
	$messagez = $mess2;
}

if( $qe == "sendproduct1" )
{
	$title1 = "send product";

	$cr1 = '';
	$cr2 = '';
	$pr1 = '';

	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
	if (isset($_GET['cr2'])){ $cr2 = $_GET['cr2'];}else{$cr2 = "";}
	if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}

	$mess2 = '
	<form action="page.php?qe=sendproduct2"
	method="POST">
	<TABLE >

	<tr class="trq"><td>amount</td><td><input type="text" name="amount1" maxlength="7"></td></tr>
	<tr class="trq"><td>product creator</td><td><input type="text" name="pcrea" maxlength="25" value='.$cr1.'></td></tr>
	<tr class="trq"><td>product</td><td><input type="text" name="product" maxlength="40" value='.$pr1.'></td></tr>
	<tr class="trq"><td>to</td><td><input type="text" name="nameto" maxlength="25" value='.$cr2.'></td></tr>
	<tr class="trq"><td></td><td><input type="submit" value="send"></td></tr>
	</TABLE >
	</form>
	';
	$messagez = $mess2;
}

if( $qe == "sendproduct2" )
{
	$title1 = "send product";

	$pcrea = $_POST["pcrea"];
	$product = $_POST["product"];
	$amount1 = $_POST["amount1"];
	$nameto = $_POST["nameto"];

	include( "../funcss/sendproduct.php" );

	$mess2 = sendproductbalance( $name1, $pcrea, $product, $amount1, $nameto, "ordinary" );

	$messagez = $mess2;
}

if( $qe == "transactions" )
{
	$title1 = "transactions";
	include '../funcss/readlog.php';

	$startfrom = '';
	$results = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}

	$mess1 = readlog( $name1, $startfrom, $results );
	$mess4 = "page.php?qe=transactions&";

	include_once( "incs3.php" );

	$mess2 = $displayResults . "<br>";

	$mess2a = "";

	for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
	{
		$mess2a .= "<tr><td>" . (float)$mess1[$i2][0] . "</td>";


	//	$mess2a .= "<td>" . $mess1[$i2][1] . "</td>";
		$mess2a .= '<td><a href="page.php?qe=user&cr1=' . $mess1[$i2][1] . '">'.$mess1[$i2][1].' </a> </td>';

		$mess2a .= '<td> <a href="page.php?qe=product
				&cr1=' . $mess1[$i2][1] . '			
				&pr1=' . $mess1[$i2][2] . '"">' . $mess1[$i2][2] . '</a> </td>';
		$mess2a .= "<td><center>" . $mess1[$i2][3] . "</center></td>";

	//	$mess2a .= "<td>" . $mess1[$i2][4] . "</td>";
	//echo "qwe" . $mess1[$i2][4] . "ew<br>";
	if( $mess1[$i2][4] == "<i>trade</i>" )
	{
		$mess2a .= "<td>trade</td>";
	}
	else if( $mess1[$i2][4] == "<i>recall</i>" )
	{
		$mess2a .= "<td>recall</td>";
	}
	else if( $mess1[$i2][4] == "<i>dividend</i>" )
	{
		$mess2a .= "<td>dividend</td>";
	}
	else if( $mess1[$i2][4] == "dividend" )
	{
		$mess2a .= "<td>dividend</td>";
	}
	else
	{
		$mess2a .= '<td><a href="page.php?qe=user&cr1=' . $mess1[$i2][4] . '">'.$mess1[$i2][4].' </a> </td>';
	}
		$mess2a .= "<td>" . $mess1[$i2][5] . "</td>";
		$mess2a .= "<td>" . $mess1[$i2][6] . "</td></tr>";
	}

	$mess2 .= "<table>" . $mess2a . "</table>";
	$mess2 .= "<br>" . $mess3 . "<br>";

	$messagez = $mess2;
}

if( $qe == "sendmessage1" )
{
	$title1 = "send message";
	$cr1 = '';
	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

	$mess2 = '
	<form action="page.php?qe=sendmessage2"
	method="POST">
	<TABLE >
	<tr class="trq"><td>send to</td><td><input type="text" name="nameto" maxlength="25" value="' . $cr1 . '"></td></tr>
	<tr class="trq"><td>message</td><td><input type="text" name="messto" maxlength="500"></td></tr>
	<tr class="trq"><td></td><td><input type="submit" value="send"></td></tr>
	</TABLE >
	</form>
	';
	
	$messagez = $mess2;
}

if( $qe == "sendmessage2" )
{
	$title1 = "send message";

	$nameto = $_POST["nameto"];
	$messto = $_POST["messto"];

	include( "../funcss/sendmessage.php" );

	$messagez = sendmessage( $name1, $nameto, $messto );
}

if( $qe == "readmessages" )
{
	$title1 = "read messages";
	include '../funcss/readmessages.php';

	$startfrom = '';
	$results = '';
	$cr1 = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

	if( $cr1 != "" )
	{
		$mess1 = readmessagesfew( $name1, $startfrom, $results, $cr1 );
		$title1 = "read $cr1 messages";
	}	
	else
	{
		$mess1 = readmessages( $name1, $startfrom, $results );
	}

	$mess4 = "page.php?qe=readmessages&";

	include_once( "incs3.php" );

	$mess2 = $displayResults . "<br>";

	for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
	{
		$type = "message";
		$product = "";

		if( $mess1[$i2][5] == "user" || $mess1[$i2][5] == "product" )
		{
			$type = "comment";
		}

		if( $mess1[$i2][6] != "" )
		{
			$product = '<a href="page.php?qe=product&cr1=' . $mess1[$i2][2] . '&pr1=' . $mess1[$i2][6] . '">'.$mess1[$i2][6].' </a>';
		}
		

		$mess2 .= "<table><tr><td>";
		$mess2 .= $type . "</td><td>";

		$mess2 .= "from : ";
		$mess2 .= '<a href="page.php?qe=user&cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a>';
		$mess2 .= "</td><td>";
		
		$mess2 .= 'to : <a href="page.php?qe=user&cr1=' . $mess1[$i2][3] . '">'.$mess1[$i2][3].' </a><br>';
		$mess2 .= " $product";
		$mess2 .= "</td><td>";



		$mess2 .= $mess1[$i2][1] . "</td><td>";
		$mess2 .= $mess1[$i2][0];

		$mess2 .= "</td></tr>";
		$mess2 .= "</table>";

		$mess2 .= $mess1[$i2][4] . "<br><br>";
	}

	$mess2 .= "<br>" . $mess3 . "<br>";
	$messagez = $mess2;
}

if( $qe == "changepassword1" )
{
	$title1 = "change password";

	$mess2 = '
	<form action="page.php?qe=changepassword2"
	method="POST">
	<TABLE >
	<tr class="trq"><td>password</td><td><input type="text" name="pass1" maxlength="25"></td></tr>
	<tr class="trq"><td>new pass</td><td><input type="text" name="pass2a" maxlength="25"></td></tr>
	<tr class="trq"><td>new pass 2</td><td><input type="text" name="pass2b" maxlength="25"></td></tr>
	<tr class="trq"><td></td><td><input type="submit" value="send"></td></tr>
	</TABLE >
	</form>
	';
	$messagez = $mess2;
}

if( $qe == "changepassword2" )
{
	$title1 = "change password";

	$pass1 = $_POST["pass1"];
	$pass2a = $_POST["pass2a"];
	$pass2b = $_POST["pass2b"];

	include( "../funcss/changepass.php" );

	$messagez = changepass( $name1, $pass1, $pass2a, $pass2b );
}

if( $qe == "createproduct1" )
{
	$title1 = "create product";
	
	$mess2 = '
	<form action="page.php?qe=createproduct2"
	method="POST">
	<TABLE >
	<tr class="trq"><td>product name</td><td><input type="text" name="pname" maxlength="25"></td></tr>

	<tr class="trq"><td>decimal places</td><td>

	<select name="decimalplaces">
	  <option value="true" selected>true</option>
	  <option value="false" >false</option>
	</select>

	</td></tr>

	<tr class="trq"><td>details</td><td><input type="text" name="pdetail" maxlength="500"></td></tr>
	<tr class="trq"><td></td><td><input type="submit" value="send"></td></tr>
	</TABLE >
	</form>
	';

	$messagez = $mess2;
}

if( $qe == "createproduct2" )
{
	$title1 = "create product";

	$pname = '';
	$pdetail = '';
	$decimalplaces = '';

	if (isset($_POST['pname'])){ $pname = $_POST['pname'];}else{$pname = "";}
	if (isset($_POST['pdetail'])){ $pdetail = $_POST['pdetail'];}else{$pdetail = "";}
	if (isset($_POST['decimalplaces'])){ $decimalplaces = $_POST['decimalplaces'];}else{$decimalplaces = "";}

	echo "$name1, $pname, $pdetail, $decimalplaces";

	include( "../funcss/createproduct.php" );

	$messagez = createproduct( $name1, $pname, $pdetail, $decimalplaces );
}

if( $qe == "deleteproduct1" )
{
	$title1 = "delete product";

	$prd1 = $_GET['prd1'];

	$mess2 = 'delete product ? ' . $prd1 . '<br>';

	$yes1 = '
	<form action="page.php?qe=deleteproduct2" method="POST">
	<TABLE >
	<tr><td>password</td><td><input type="text" name="pass1" maxlength="25"></td></tr>
	<input type="hidden" name="pname" value="' . $prd1 . '">
	<tr><td></td><td><input type="submit" value="delete"></td></tr>
	</TABLE >
	</form>
	';

	$no1 = '<a href="page.php?qe=myproducts&startfrom=0&results=5">don\'t delete</a>';
	$mess2 .= $yes1.'<br>'.$no1.'';

	$messagez = $mess2;
}

if( $qe == "deleteproduct2" )
{
	$title1 = "delete product";

	$pname = $_POST["pname"];
	$pass1 = $_POST["pass1"];

	include( "../funcss/deleteproduct.php" );

	$messagez = deleteproduct( $name1, $pass1, $pname );
}

if( $qe == "deletetrade1" )
{
	$title1 = "delete trade";

	$trd1 = $_GET['trd1'];

	$mess2 = 'delete trade ?<br>';

	$yes1 = '
	<form action="page.php?qe=deletetrade2" method="POST">
	<input type="hidden" name="traden" value="' . $trd1 . '">
	<input type="submit" value="delete">
	</form>
	';

	$no1 = '<a href="listptrades1.php?startfrom=0&results=5">don\'t delete</a>';
	$mess2 .= $yes1.'<br>'.$no1.'';

	$messagez = $mess2;
}

if( $qe == "div1" )
{
	$title1 = "send dividend";

	

	$pr1 = "";

	if (isset($_GET['pr1'])) $pr1 = $_GET['pr1'];

	include( "../funcss/sendproduct.php" );

	$mess2 = '
	<form action="page.php?qe=div2"
	method="POST">
	<TABLE >
	<tr class="trq">

	<td></td>
	<td>amount</td>
	<td>creator</td>
	<td>product</td>
	</tr>

	<tr class="trq">

	<td></td>

	<td>
	to the holder of every 1
	</td>

	<td>'.$name1.'</td>
	<td><input type="text" name="pr1" maxlength="25" value="' . $pr1 . '"></td></tr>
			
	<tr class="trq">
	<td>send</td>
	<td><input type="text" name="am1" maxlength="25" value="1"></td>
	<td><input type="text" name="cr2" maxlength="25"></td>
	<td><input type="text" name="pr2" maxlength="25"></td>
	</tr>
			
	<tr class="trq"><td></td><td><input type="submit" value="send"></td><td></td><td></td></tr>
			
	</TABLE >
	</form>
	';

	$messagez = $mess2;
}

if( $qe == "div2" )
{
	$title1 = "send dividend";

	$pr1 = '';
	$cr2 = '';
	$pr2 = '';
	$am1 = '';

	if (isset($_POST['pr1'])){ $pr1 = $_POST['pr1'];}else{$pr1 = "";}
	if (isset($_POST['cr2'])){ $cr2 = $_POST['cr2'];}else{$cr2 = "";}
	if (isset($_POST['pr2'])){ $pr2 = $_POST['pr2'];}else{$pr2 = "";}
	if (isset($_POST['am1'])){ $am1 = $_POST['am1'];}else{$am1 = "";}

	include( "../funcss/divs.php" );

	$var1a = sendiv1( $name1, $pr1, $cr2, $pr2, $am1 );

	$var2 = $var1a[1];

	if( $var1a[0] == 'true' )
	{
		$var2 .= '
		<form action="page.php?qe=div3" method="POST">
		<TABLE>
		
		<input type="hidden" name="pr1" value="' . $pr1 . '">
		<input type="hidden" name="cr2" value="' . $cr2 . '">
		<input type="hidden" name="pr2" value="' . $pr2 . '">
		<input type="hidden" name="am1" value="' . $am1 . '">
		<input type="hidden" name="prevmax" value="' . $var1a[2] . '">
		
		<tr></tr><td><input type="submit" value="send"></td></tr>
		</TABLE >
		</form>
		';
	}

	$messagez = "$var2";
}

if( $qe == "div3" )
{
	$title1 = "send dividend";

	$pr1 = '';
	$cr2 = '';
	$pr2 = '';
	$am1 = '';
	$prevmax = '';

	if (isset($_POST['pr1'])){ $pr1 = $_POST['pr1'];}else{$pr1 = "";}
	if (isset($_POST['cr2'])){ $cr2 = $_POST['cr2'];}else{$cr2 = "";}
	if (isset($_POST['pr2'])){ $pr2 = $_POST['pr2'];}else{$pr2 = "";}
	if (isset($_POST['am1'])){ $am1 = $_POST['am1'];}else{$am1 = "";}
	if (isset($_POST['prevmax'])){ $prevmax = $_POST['prevmax'];}else{$prevmax = "";}

	include( "../funcss/divs.php" );

	$var1a = sendiv2( $name1, $pr1, $cr2, $pr2, $am1, $prevmax );

	$var2 = $var1a[1];

	if( $var1a[0] == 'true' )
	{
		$var2 .= '
		<form action="page.php?qe=div3" method="POST">
		<TABLE>
		
		<input type="hidden" name="pr1" value="' . $pr1 . '">
		<input type="hidden" name="cr2" value="' . $cr2 . '">
		<input type="hidden" name="pr2" value="' . $pr2 . '">
		<input type="hidden" name="am1" value="' . $am1 . '">
		<input type="hidden" name="prevmax" value="' . $var1a[2] . '">
		
		<tr></tr><td><input type="submit" value="send"></td></tr>
		</TABLE >
		</form>
		';
	}

	$messagez = "$var2";
}

if( $qe == "edittrade1" )
{
	$title1 = "edit trade";

	include( "../funcss/edittrade.php" );

	$txno = $_GET['txno'];

	$mess2 = gettrade( $name1, $txno );

	$mess30 = '
	<option selected value="sell">sell</option>
	<option value="buy">buy</option>
	';

	if( $mess2[6] == "buy")
	{
		$mess30 = '
		<option value="sell">sell</option>
		<option selected value="buy">buy</option>
		';
		$cs = $mess2[1];
		$ps = $mess2[2];
		
		$mess2[1] = $mess2[3];
		$mess2[2] = $mess2[4];
		
		$mess2[3] = $cs;
		$mess2[4] = $ps;
	}

	$mess3 = '
	<form action="page.php?qe=edittrade2"
	method="POST">
	<TABLE >
	<tr class="trq">

	<td></td>
	<td>amount</td>
	<td>creator</td>
	<td>product</td><td></td>
	</tr>
			
	<tr class="trq">
	<td>
			
	<select name="buysell">;'.$mess30.'
	  value=buy
	</select>
			
	</td>
	<td><input type="text" name="amount1" maxlength="25" value="'.$mess2[0].'"></td>
	<td><input type="text" name="cr1" maxlength="25" value="'.$mess2[1].'"</td>
	<td><input type="text" name="pr1" maxlength="25" value="'.$mess2[2].'"</td><td></td></tr>

	<tr class="trq">
	<td>for</td>
	<td><input type="text" name="amount2" maxlength="25" value="'.$mess2[5].'"</td>
	<td><input type="text" name="cr2" maxlength="25" value="'.$mess2[3].'"</td>
	<td><input type="text" name="pr2" maxlength="25" value="'.$mess2[4].'"</td>
	<td>each</td></tr>

	<input type="hidden" name="txno" value="' . $txno . '">
	<tr class="trq"><td></td><td><input type="submit" value="send"></td><td></td><td></td><td></td></tr>
			
	</TABLE >
	</form>
	';

	$mess4 = "
			<br><center>
			<a href=\"edittrade3.php?tdn=$txno\">or</a>
			</center>
	";
	$mess3 .= $mess4;

	$messagez = $mess3;
}

if( $qe == "edittrade2" )
{
	$title1 = "set trade";

	$txno = $_POST["txno"];
	$buysell = $_POST["buysell"];

	$amount1 = $_POST["amount1"];
	$pcrea1 = $_POST["cr1"];
	$product1 = $_POST["pr1"];

	$amount2 = $_POST["amount2"];
	$pcrea2 = $_POST["cr2"];
	$product2 = $_POST["pr2"];

	include( "../funcss/settrade.php" );

	$messagez = edittrade( $amount1, $pcrea1, $product1,
 					$amount2, $pcrea2, $product2,
 					$buysell, $name1,  $txno );

}

if( $qe == "edittrade3" )
{
	$title1 = "order";

	

	$nm1 = "";
	$passw = "";
	$tdn = "";

	$cr1 = "";
	$pr1 = "";

	$cr2 = "";
	$pr2 = "";

	$am1 = "";
	$am2 = "";

	if (isset($_GET['nm1'])) $nm1 = $_GET['nm1'];
	if (isset($_GET['passw'])) $passw = $_GET['passw'];
	if (isset($_GET['tdn'])) $tdn = $_GET['tdn'];

	if (isset($_GET['amount'])) $am1 = $_GET['amount'];
	if (isset($_GET['price'])) $am2 = $_GET['price'];

	if( $nm1 == "" && $passw == "" ) // && $tdn == ""
	{
		if( $tdn == "" )
		{
			$tdn = "<i>tradenumber</i>";
		}
		else
		{
			$tdn = "<b>$tdn</b>";
		}
		$mess2 ="			
	page.php?qe=edittrade3<br>
	nm1=<b>$name1</b>&<br>
	passw=<i>password</i>&<br>
	tdn=$tdn&<br>
	amount=<i>amount</i>&<br>
	price=<i>price</i>
				<br><br>
	";
	}
	else
	{
		include( "../funcss/settrade.php" );

		$mess2 = edittrade3( $nm1, $passw, $tdn, $am1, $am2 );
	}

	$messagez = $mess2;
}

if( $qe == "product" )
{
	$title1 = "product";

	include '../funcss/productf.php';

	$startfrom = '';
	$results = '';
	$cr1 = '';
	$pr1 = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}

	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
	if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}

	$mess2b = productdetail($cr1, $pr1);
	$mess0 = "";

	if( $mess2b[0] =="blank" )
	{
		$mess0 = "$cr1 $pr1 not found";
	}
	else if( $mess2b[0] == "removed" )
	{
		$mess0 = "product $cr1 $pr1 has been deleted";
	}
	else
	{
		$title1 = "product $cr1 $pr1";
		$mess0 = $mess2b[0] . ", " . $mess2b[1] . ", " . $mess2b[2];
		$mess0 = "<b>$cr1 $pr1</b><br><br>";
		$mess2a = "<tr><td>creator</td><td><a href=\"page.php?qe=user&cr1=$cr1\">$cr1</a></td></tr>";
		$mess2a .= "<tr><td>product</td><td>$pr1</td></tr>";
		
		$var1 = "true";
		if ( $mess2b[3] == 0 )
		{
			$var1 = "false";
		}
		
		$mess2a .= "<tr><td>decimal places</td><td>$var1</td></tr>";
		$mess2a .= "<tr><td>create date</td><td>$mess2b[2]</td></tr>";
		$mess2a .= "<tr><td>details</td><td>$mess2b[1]</td></tr>";

		$mess0 .= '<table class="blue">' . $mess2a . '</table>';
		

		$mess2c = '<a href="page.php?qe=sendproduct1
				&cr1=' . $cr1 . '
				&pr1=' . $pr1 . '">send</a>';
		$mess2d = '<a href="page.php?qe=settrade1&am1=1
				&type1=buy
				&cr1=' . $cr1 . '
				&pr1=' . $pr1 . '"
				>buy</a>';
		$mess2e = '<a href="page.php?qe=settrade1&am1=1
				&type1=sell
				&cr1=' . $cr1 . '
				&pr1=' . $pr1 . '"
				>sell</a>';
				
		include_once '../funcss/divs.php';
		$mess2e3 = countdivs1( $cr1, $pr1 );

		$mess2e2 = '<a href="page.php?qe=dividends
				&cr1=' . $cr1 . '
				&pr1=' . $pr1 . '"
				>dividends( '.$mess2e3.' )</a>';
		$mess2f = '<a href="page.php?qe=prices
				&cr1=' . $cr1 . '
				&pr1=' . $pr1 . '"
				>prices</a>';
		$mess2j = '<a href="page.php?qe=sendcomment1
				&cr1=' . $cr1 . '
				&pr1=' . $pr1 . '"
				>place a comment</a>';

		include '../funcss/readmessages.php';

		$mess1 = readProductComments( $cr1, $pr1, $startfrom, $results );

		$mess4 = "page.php?qe=product&cr1=$cr1&pr1=$pr1&";

		include_once( "incs3.php" );

		$mess2i = "";

		for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
		{
			$mess2i .= "<table><tr><td>";

			$mess2i .= "from : ";
			$mess2i .= '<a href="page.php?qe=user&cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a>';
			$mess2i .= "</td><td>";
			

			$mess2i .= $mess1[$i2][1];
			$mess2i .= "</td><td>";
			$mess2i .= $mess1[$i2][0];

			$mess2i .= "</td></tr>";
			$mess2i .= "</table>";

			$mess2i .= $mess1[$i2][3] . "<br><br>";
		}
	
		$mess2g = "$mess2c<br>$mess2d<br>$mess2e<br>$mess2f<br>$mess2e2";
		$mess2f = "<table><tr><td>$mess2c</td><td>$mess2d</td><td>$mess2e</td><td>$mess2e2</td><td>$mess2f</td></table>";
			
		$mess0 .= '<br>' . $mess2g;
		$mess0 .= '<br>' . $mess2j;

		$mess0 .= "<br><br><br><b>comments : </b>";
		$mess0 .= "$displayResults<br>";

		$mess0 .= $mess2i . $mess3;
	}

	$messagez = $mess0;
}

if( $qe == "user" )
{
	$title1 = "user";

	include '../funcss/productf.php';

	$startfrom = '';
	$results = '';
	$cr1 = '';

	if (isset($_GET['startfrom'])){ $startfrom = $_GET['startfrom'];}else{$startfrom = "0";}
	if (isset($_GET['results'])){ $results = $_GET['results'];}else{$results = "10";}
	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}

	$mess0 = "";

	$title1 = "user $cr1";

	$mess0 = "<b>$cr1</b><br><br>";


	$mess2c = '<a href="page.php?qe=sendproduct1
				&cr2=' . $cr1 . '">send to</a>';
	$mess2d = '<a href="page.php?qe=products
				&cr1=' . $cr1 . '"
				>products</a>';
	$mess2e = '<a href="page.php?qe=prices
				&cr2=' . $cr1 . '"
				>prices</a>';

	include_once '../funcss/divs.php';
	$mess2e3 = countdivs2( $cr1 );

	$mess2e2 = '<a href="page.php?qe=dividends
				&cr2=' . $cr1 . '"
				>dividends( '.$mess2e3.' )</a>';
	$mess2f = '<a href="page.php?qe=sendmessage1
				&cr1=' . $cr1 . '"
				>send message</a>';
	$mess2g = '<a href="page.php?qe=readmessages
				&cr1=' . $cr1 . '"
				>read messages</a>';
	$mess2j = '<a href="page.php?qe=sendcomment1
				&cr1=' . $cr1 . '"
				>place comment</a>';

	include '../funcss/readmessages.php';

	$mess1 = readUserComments( $cr1, $startfrom, $results );

	$mess4 = "page.php?qe=user&cr1=$cr1&";

	include_once( "incs3.php" );

	$mess2i = "";

	for( $i2 = 1; $i2 < sizeof($mess1); $i2++ )
	{
		$mess2i .= "<table><tr><td>";

		$mess2i .= "from : ";
		$mess2i .= '<a href="page.php?qe=user&cr1=' . $mess1[$i2][2] . '">'.$mess1[$i2][2].' </a>';
		$mess2i .= "</td><td>";

		$mess2i .= $mess1[$i2][1];
		$mess2i .= "</td><td>";
		$mess2i .= $mess1[$i2][0];

		$mess2i .= "</td></tr>";
		$mess2i .= "</table>";

		$mess2i .= $mess1[$i2][3] . "<br><br>";
	}

	$mess2 = $displayResults . "<br>";

	$mess0 .= "$mess2c<br>$mess2d<br>$mess2e<br>$mess2e2<br><br>$mess2f<br>$mess2g<br>$mess2j";

	$mess0 .= "<br><br><br><b>comments : </b>";
	$mess0 .= "$displayResults<br>";

	$mess0 .= $mess2i . $mess3;

	$messagez = $mess0;
}

if( $qe == "market" )
{
	$title1 = "market";

	$cr1 = "";
	$pr1 = "";

	$cr2 = "";
	$pr2 = "";

	if (isset($_GET['cr1'])) $cr1 = $_GET['cr1'];
	if (isset($_GET['pr1'])) $pr1 = $_GET['pr1'];
	if (isset($_GET['cr1'])) $cr2 = $_GET['cr2'];
	if (isset($_GET['pr2'])) $pr2 = $_GET['pr2'];

	include '../funcss/listtrades2.php';

	$mess3 = listdep($cr1, $pr1, $cr2, $pr2, 1 );
	$mess5 = listdep($cr2, $pr2, $cr1, $pr1, 2 );

	$mess7 = listdep2( $cr1, $pr1, $cr2, $pr2, 2 );

	$mess4 = "";
	$highbid = 0;

	$var1 = $mess7[0];

	//~ echo "qwe : $var1 <br>";

	for( $i2 = 0; $i2 < sizeof( $mess7[1] ); $i2++ )
	{
		$sum = $mess7[1][$i2][0] / $mess7[1][$i2][1];
		$mess4 .= "<tr><td>" . number_format((float)$sum, 3, '.', '') * 1 . "</td>";
		$mess4 .= "<td>for</td>";
		$mess4 .= "<td>" . $mess7[1][$i2][1] * 1 . "</td>";
		$mess4 .= "<td>each</td>";
		$mess4 .= "<td>( " . $mess7[1][$i2][0] * 1 . " )</td>";
		$mess4 .= "</tr>";
		if( $i2 == 0 )
		{
			$highbid = (float)number_format( $mess7[1][$i2][1],6);
		}
	}

	$mess6 = "";

	$lowask = 0;

	for( $i2 = 0; $i2 < sizeof($mess7[2]); $i2++ )
	{
	#	echo $i2 . " :; " . $mess5[$i2][0] . " :: " . $mess5[$i2][1] . " .. " . $mess5[$i2][0] * $mess5[$i2][1] . "<br>";
		$sum = $mess7[2][$i2][0] * $mess7[2][$i2][1];
		$mess6 .= "<tr><td>" . 1 * $mess7[2][$i2][0] . "</td>";
		$mess6 .= "<td>for</td>";
		$mess6 .= "<td>" . 1 * $mess7[2][$i2][1] . "</td>";
		$mess6 .= "<td>each</td>";
		$mess6 .= "<td>( " . number_format((float)$sum, 3, '.', '') * 1 . " )</td>";
		$mess6 .= "</tr>";
		if( $i2 == 0 )
		{
			$lowask = (float)number_format( $mess7[2][$i2][1],6);
		}
	}


	if ( $var1 == 0 )
	{
		$bidlink = "bids";
		$asklink = "asks";
	}
	else
	{
	$bidlink = '<a href="page.php?qe=settrade1&am1=' . $highbid . '
			&type1=sell
			&cr1=' . $cr1 . '
			&pr1=' . $pr1 . '
			&cr2=' . $cr2 . '
			&pr2=' . $pr2 . '"
			>bids</a></td>';

	$asklink = '<a href="page.php?qe=settrade1&am1=' . $lowask . '
			&type1=buy
			&cr1=' . $cr1 . '
			&pr1=' . $pr1 . '
			&cr2=' . $cr2 . '
			&pr2=' . $pr2 . '"
			>asks</a></td>';
	}

	$var10 = "";

	$revers = '<a href="page.php?qe=market
				&cr1=' . $cr2 . '			
				&pr1=' . $pr2 . '			
				&cr2=' . $cr1 . '			
				&pr2=' . $pr1 . '""><b>_/&#175' . $var10 . '</b></a>';
				
	$mess9 = '
			<center>    <table  id="t3">
				  <tr>
					 <td>
					 <a href="page.php?qe=user&cr1=' . $cr1 . '">'.$cr1 .' </a>
					 
					 </td>
					 
					 <td><a href="page.php?qe=product&cr1=' . $cr1 . '&pr1=' . $pr1 . '">' . $pr1 . '</a></td>
					 
					 <td><center>'.$revers.'</center></td>
					  <td><div id="myText"><a href="page.php?qe=user&cr1=' . $cr2 . '">'.$cr2 .' </a></div> </td>
					 <td><div id="myText"><td><a href="page.php?qe=product&cr1=' . $cr2 . '&pr1=' . $pr2 . '">' . $pr2 . '</a></td></div> </td>
				  </tr>
			  </table>
			  <center>
			  <br><br>
			  
				<table  id="t1">
				  <tr>
					 <td><b>' . $bidlink . '</b></td><td></td><td></td><td></td><td></td>
				  </tr>';

	$mess92 =  '
			</table>
				
				<!-- Table 2 markup-->
			<table id="t2"> 
				  <tr>
					 <td><b>'.$asklink.'</b></td><td></td><td></td><td></td><td></td>
				  </tr>';
				  
	$mess93 = '  
			</table>  
			</div>
			</body>
			</html>
	';

	$mess93 = '</table>';

	$mess9 = $mess9 . $mess4 . $mess92 . $mess6 . $mess93;

	$messagez = $mess9;
}

if( $qe == "settrade1" )
{
	$title1 = "set trade";

	

	$cr1 = "";
	$pr1 = "";

	$cr2 = "";
	$pr2 = "";

	$am1 = "1";
	$type1 = "sell";

	if (isset($_GET['cr1'])) $cr1 = $_GET['cr1'];
	if (isset($_GET['pr1'])) $pr1 = $_GET['pr1'];
	if (isset($_GET['cr2'])) $cr2 = $_GET['cr2'];
	if (isset($_GET['pr2'])) $pr2 = $_GET['pr2'];

	if (isset($_GET['am1'])) $am1 = $_GET['am1'];
	if (isset($_GET['type1'])) $type1 = $_GET['type1'];

	$selected1 = "";
	$selected2 = "";

	if( $type1 == "buy" )
	{
		$selected1 = "selected";
	}
	else
	{
		$selected2 = "selected";
	}

	$mess2 = '
	<form action="page.php?qe=settrade2"
	method="POST">
	<TABLE >
	<tr class="trq">

	<td></td>
	<td>amount</td>
	<td>creator</td>
	<td>product</td><td></td>
	</tr>
			
	<tr class="trq">
	<td>
			
	<select name="buysell">
	  <option value="sell" '. $selected2 .'>sell</option>
	  <option value="buy" '. $selected1 .'>buy</option>
	</select>
			
	</td>
	<td><input type="text" name="amount1" maxlength="25" value="1"></td>
	<td><input type="text" name="cr1" maxlength="25" value="' . $cr1 . '"</td>
	<td><input type="text" name="pr1" maxlength="25"value="' . $pr1 . '"</td><td></td></tr>
	
	<tr class="trq">
	<td>for</td>
	<td><input type="text" name="amount2" maxlength="25" value="' . $am1 . '"></td>
	<td><input type="text" name="cr2" maxlength="25"value="' . $cr2 . '"</td>
	<td><input type="text" name="pr2" maxlength="25"value="' . $pr2 . '"</td>
	<td>each</td></tr>
			
	<tr class="trq"><td></td><td><input type="submit" value="send"></td><td></td><td></td><td></td></tr>
			

	</TABLE >
	</form>
	';

	$messagez = $mess2;
}

if( $qe == "settrade2" )
{
	$title1 = "set trade";

	$amount1 = $_POST["amount1"];
	$pcrea1 = $_POST["cr1"];
	$product1 = $_POST["pr1"];

	$amount2 = $_POST["amount2"];
	$pcrea2 = $_POST["cr2"];
	$product2 = $_POST["pr2"];

	$buysell = $_POST["buysell"];

	include( "../funcss/settrade.php" );

	$messagez = settradeb( $name1, $amount1, $pcrea1, $product1, $amount2, $pcrea2, $product2, $buysell );
}

if( $qe == "sendcomment1" )
{
	$title1 = "send comment";

	$cr1 = '';
	$pr1 = '';

	if (isset($_GET['cr1'])){ $cr1 = $_GET['cr1'];}else{$cr1 = "";}
	if (isset($_GET['pr1'])){ $pr1 = $_GET['pr1'];}else{$pr1 = "";}

	$mess3 = '<tr class="trq"><td></td><td><input type="text" name="pr1" maxlength="25" value="' . $pr1 . '"></td></tr>';
	if ( $pr1 == '' )
	{
		$mess3 = "";
	}

	$mess1 = '
	<form action="page.php?qe=sendcomment2"
	method="POST">
	<TABLE >
	<tr class="trq"><td>send to</td><td><input type="text" name="nameto" maxlength="25" value="' . $cr1 . '"></td></tr>'
	. $mess3 . 
	'<tr class="trq"><td>comment</td><td><input type="text" name="messto" maxlength="500"></td></tr>
	<tr class="trq"><td></td><td><input type="submit" value="send"></td></tr>
	</TABLE >
	</form>
	';

	$messagez = $mess1;
}

if( $qe == "sendcomment2" )
{
	$title1 = "send comment";

	$cr1 = '';
	$pr1 = '';
	$messto = '';

	if (isset($_POST['nameto'])){ $cr1 = $_POST['nameto'];}else{$cr1 = "";}
	if (isset($_POST['pr1'])){ $pr1 = $_POST['pr1'];}else{$pr1 = "";}
	if (isset($_POST['messto'])){ $messto = $_POST['messto'];}else{$messto = "";}

	echo "$cr1 $pr1 qe";

	$mess2 ="";

	include( "../funcss/sendmessage.php" );

	if ( $pr1 == '' )
	{
		$mess2 = sendComment( $name1, $cr1, $messto );
	}
	else
	{
		$mess2 = sendProductComment( $name1, $cr1, $pr1, $messto );
	}

	$messagez = $mess2;	
}
?>
