<?php

class sms
{

	function SMSForm( )
	{
	
		echo "\t\t\t\t\t<center><h2>South African Revenue Services</h2><h3>Short Message Service Console</h3></center>\n";
		echo "\t\t\t\t\t<table width=100% border=solid width=1>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<th colspan=4>\n";
		echo "\t\t\t\t\t\t\t\tFamous phone numbers\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tJurie Prinsloo\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t0835553500\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tAndre Scheepers\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t0834199661\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tLouise Beer\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t0824565898\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tVusa Moyo\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t0810368185\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tJacques Peterson\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tRavi Rajah\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tThiru Naidoo\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t0844444915\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tDave le Roux\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tAIX Standby\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t0832922246\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tLinux Standby\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t0731677951\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t</table>\n";
		echo "\t\t\t\t\t<br>\n";
		echo "\t\t\t\t\t<form id='smsform' name='smssend' method='post' action='index.php?option=sendsms'>\n";
		echo "\t\t\t\t\t\t<table>\n";
		echo "\t\t\t\t\t\t\t<tr>\n";
#		echo "\t\t\t\t\t\t\t\t<th>\n";
#		echo "\t\t\t\t\t\t\t\t\tEnter the cell numbers to send to :\n";
#		echo "\t\t\t\t\t\t\t\t</th>\n";
#		echo "\t\t\t\t\t\t\t\t<td>\n";
#		echo "\t\t\t\t\t\t\t\t\t<textarea name='cellnumbers' rows='10' cols='10'>\n";
#		echo "\t\t\t\t\t\t\t\t\t</textarea>\n";
#		echo "\t\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t\t<th>\n";
		echo "\t\t\t\t\t\t\t\t\tEnter the cell number to send to :\n";
		echo "\t\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t\t<input name='cellnumbers' size=10 >\n";
		echo "\t\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t\t<th>\n";
		echo "\t\t\t\t\t\t\t\t\tEnter the message :\n";
		echo "\t\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t\t<textarea name='cellmessage' rows='4' cols='40' onKeyDown='limitText(this.form.cellmessage,this.form.countdown,160);' onKeyUp='limitText(this.form.cellmessage,this.form.countdown,160);' style='resize: none;'></textarea>\n";
		echo "\t\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t</table>\n";
		echo "\t\t\t\t\t\t<font size='1'>(Maximum characters: 160)<br>\n";
		echo "\t\t\t\t\t\t\tYou have <input readonly type='text' name='countdown' size='3' value='160'> characters left.\n";
		echo "\t\t\t\t\t\t</font>\n";
		echo "\t\t\t\t\t\t<center>\n";
		echo "\t\t\t\t\t\t\t<input type=submit value='Send'>\n";
		echo "\t\t\t\t\t\t</center>\n";
		echo "\t\t\t\t\t\t<p>\n";
		echo "\t\t\t\t\t\t\tThis page is for the benefit of the SARS Unix team only. Only one cell number at a time is allowed for now.\n";
		echo "\t\t\t\t\t\t</p>\n";
		echo "\t\t\t\t\t</form>\n";



		include("config.php");

                mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
                mysql_select_db( $dbname );

	}

}

?>
