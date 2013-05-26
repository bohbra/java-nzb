<?php
$series_xml="D:\Applications\JavaNZB\JavaNZB.series";
$version="0.5";

if ($_POST["action"] == "Del") {

	$data = file_get_contents($series_xml);
	$newdata ='<TVSeries></TVSeries>';
	$xml = new SimpleXMLElement($data);
	$xmlnew = new SimpleXMLElement($newdata);

	foreach ($xml->Show as $Show)  {
		if ($Show->Name <> stripslashes($_POST["show"]) || ($Show->Name == stripslashes($_POST["show"]) && $Show->Format <> stripslashes($_POST["format"]))) {
			$newshow = $xmlnew->addChild('Show');
			$newshow->addChild('Name',$Show->Name); 
			$newshow->addChild('Season',$Show->Season); 
			$newshow->addChild('Episode',$Show->Episode); 
			$newshow->addChild('Format',$Show->Format); 
			$newshow->addChild('Next',$Show->Next); 
			$newshow->addChild('Language',$Show->Language); 
			$newshow->addChild('SearchBy',$Show->SearchBy);
			}
		}
		
		$doc = new DOMDocument('1.0');
		$doc->formatOutput = true;
		$domnode = dom_import_simplexml($xmlnew);
		$domnode = $doc->importNode($domnode, true);
		$domnode = $doc->appendChild($domnode);

		file_put_contents($series_xml, $doc->saveXML());

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
	exit;
} elseif ($_POST["action"] == "Add Show" or $_POST["action"] == "Edit") {

	print '
		<link rel="stylesheet" type="text/css" href="style.css">
		<TABLE>
		<form method=post action=index.php>
			
		 	<TR> <TD> Name of show<TD> <input type="text" name="in_show" size=40 value="'; print stripslashes($_POST["show"]); print '">
			<TR> <TD> Episode on disk <TD> <input type=text name=in_season size=3 value="'; print $_POST["season"]; print '">x<input type=text name=in_episode size=3 value="'; print $_POST["episode"]; print '">

			<TR> <TD> Language <TD> <SELECT MULTIPLE NAME=in_language[] size=5>
						<option value=4096 '; if ($_POST["language"] == 4096 or $_POST["action"] == "Add Show") print SELECTED; print '>English    
						<option value=32 '; if ($_POST["language"] == 32) print SELECTED; print '>Dutch      
						<option value=2 '; if ($_POST["language"] == 2) print SELECTED; print '>French     
						<option value=4 '; if ($_POST["language"] == 4) print SELECTED; print '>German     
						<option value=8 '; if ($_POST["language"] == 8) print SELECTED; print '>Spanish    
						<option value=16 '; if ($_POST["language"] == 16) print SELECTED; print '>Danish     
						<option value=64 '; if ($_POST["language"] == 64) print SELECTED; print '>Japanese   
						<option value=128 '; if ($_POST["language"] == 128) print SELECTED; print '>Korean     
						<option value=256 '; if ($_POST["language"] == 256) print SELECTED; print '>Russian    
						<option value=512 '; if ($_POST["language"] == 512) print SELECTED; print '>Italian    
						<option value=1024 '; if ($_POST["language"] == 1024) print SELECTED; print '>Cantonese 
						<option value=2048 '; if ($_POST["language"] == 2048) print SELECTED; print '>Polish     
						<option value=8192 '; if ($_POST["language"] == 8192) print SELECTED; print '>Vietnamese 
						<option value=16384 '; if ($_POST["language"] == 16384) print SELECTED; print '>Swedish    
						<option value=32768 '; if ($_POST["language"] == 32768) print SELECTED; print '>Norwegian  
						<option value=65536 '; if ($_POST["language"] == 65536) print SELECTED; print '>Finnish    
						<option value=131072 '; if ($_POST["language"] == 131072) print SELECTED; print '>Mandarin   
						<option value=1073741824 '; if ($_POST["language"] == 1073741824) print SELECTED; print '>Unknown    
						</SELECT>
						Use CTRL to select multiple Languages.
						
			<TR> <TD> Format <TD> 	<SELECT MULTIPLE NAME=in_format[] size=5>
						 <option value=17 '; if ($_POST["format"] == 17 or $_POST["action"] == "Add Show") print SELECTED; print '>Xvid
                         <option value=131072 '; if ($_POST["format"] == 131072) print SELECTED; print '>x264
						 <option value=2 '; if ($_POST["format"] == 2) print SELECTED; print '>DVD 
						 <option value=4 '; if ($_POST["format"] == 4) print SELECTED; print '>SVCD
						 <option value=8 '; if ($_POST["format"] == 8) print SELECTED; print '>VCD 
						 <option value=32 '; if ($_POST["format"] == 32) print SELECTED; print '>HDts
						 <option value=64 '; if ($_POST["format"] == 64) print SELECTED; print '>WMV
						 <option value=128 '; if ($_POST["format"] == 128) print SELECTED; print '>Other
						 <option value=256 '; if ($_POST["format"] == 256) print SELECTED; print '>ratDVD
						 <option value=512 '; if ($_POST["format"] == 512) print SELECTED; print '>Ipod  
					     <option value=1024 '; if ($_POST["format"] == 1024) print SELECTED; print '>PSP
						 <option value=0 '; if ($_POST["format"] == 0) print SELECTED; print '>Any
							     </Select>
						Use CTRL to select multiple formats
						
			<TR> <TD> Search Method <TD> 	<SELECT NAME=in_searchby size=5>
						 <option value="ShowName Season x Episode" '; if ($_POST["searchby"] == "ShowName Season x Episode" or $_POST["action"] == "Add Show") print SELECTED; print '>ShowName Season x Episode
						 <option value="Showname SeriesNum" '; if ($_POST["searchby"] == "Showname SeriesNum") print SELECTED; print '>Showname SeriesNum
						 <option value="Showname YYYY-MM-DD" '; if ($_POST["searchby"] == "Showname YYYY-MM-DD") print SELECTED; print '>Showname YYYY-MM-DD
					     <option value="Showname EpisodeTitle" '; if ($_POST["searchby"] == "Showname EpisodeTitle") print SELECTED; print '>Showname EpisodeTitle
						 </Select>
						
		</TABLE>
		<input TYPE="hidden" name=show VALUE="'; print stripslashes($_POST["show"]); print '">'; 
        
        
        
		if ($_POST["action"] == "Edit")
        {
            print '<input TYPE="hidden" name=format VALUE="'; print stripslashes($_POST["format"]); print '">'; 
			print '<input TYPE="submit" name=action VALUE="Update"> </form>';
        }
		else
			print '<input TYPE="submit" name=action VALUE="Add"> </form>';
} elseif ($_POST["action"] == "Add" or $_POST["action"] == "Update") {

	##Delete old showname##  
	$data = file_get_contents($series_xml);
	$newdata ='<TVSeries></TVSeries>';
	$xml = new SimpleXMLElement($data);
	$xmlnew = new SimpleXMLElement($newdata);

	foreach ($xml->Show as $Show)  {
		if ($Show->Name <> stripslashes($_POST["show"]) or ($Show->Name == stripslashes($_POST["show"]) && $Show->Format <> stripslashes($_POST["format"]))) {
    			$newshow = $xmlnew->addChild('Show');
    			$newshow->addChild('Name',$Show->Name); 
    			$newshow->addChild('Season',$Show->Season); 
    			$newshow->addChild('Episode',$Show->Episode); 
    			$newshow->addChild('Format',$Show->Format); 
    			$newshow->addChild('Next',$Show->Next); 
    			$newshow->addChild('Language',$Show->Language); 
    			$newshow->addChild('SearchBy',$Show->SearchBy);
		}
	}
		
		$doc = new DOMDocument('1.0');
		$doc->formatOutput = true;
		$domnode = dom_import_simplexml($xmlnew);
		$domnode = $doc->importNode($domnode, true);
		$domnode = $doc->appendChild($domnode);

		file_put_contents($series_xml, $doc->saveXML());
	################
	
	$data = file_get_contents($series_xml);
	$xml = new SimpleXMLElement($data);

	$newshow = $xml->addChild('Show');
	$newshow->addChild('Name',stripslashes($_POST["in_show"])); 
	$newshow->addChild('Season',$_POST["in_season"]); 
	$newshow->addChild('Episode',$_POST["in_episode"]);
	$newshow->addChild('Next','Unknown'); 
	$newshow->addChild('SearchBy',$_POST["in_searchby"]);
	$out_format = 0;
	foreach ($_POST["in_format"] as $in_for ) {
		$out_format=$out_format+$in_for;
	}
	$newshow->addChild('Format',$out_format); 
	$out_lang = 0;
	foreach ($_POST["in_language"] as $in_lang) {
		$out_lang=$out_lang+$in_lang;
	}
	$newshow->addChild('Language',$out_lang); 

	$string = $xml->asXML();
	$string = preg_replace("/>\s*</",">\n<",$string);
	$xmlArray = explode("\n",$string);
	$currIndent = 0;
	$string = array_shift($xmlArray) . "\n";
	foreach($xmlArray as $element) {
		if (preg_match('/^<([\w])+[^>\/]*>$/U',$element)) {
			$string .=  str_repeat(' ', $currIndent) . $element . "\n";
			$currIndent += 1;
			}
		elseif ( preg_match('/^<\/.+>$/',$element)) {
		       	$currIndent -= 1;
		        $string .=  str_repeat(' ', $currIndent) . $element . "\n";
		       	}
		else {
		       	$string .=  str_repeat(' ', $currIndent) . $element . "\n";
		      	}
		}

	file_put_contents($series_xml, $string);

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
	exit;
} else {
        $data = file_get_contents($series_xml);
	$xml = new SimpleXMLElement($data);

	print "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">";
	print "<TABLE id=\"table1\">";
	print "	<TR> 
	<TH  ALIGN=right><a href='index.php?sort=Series'>Series</a></TH> 
	<TH  ALIGN=center>Downloaded Episode</TH>
	<TH  ALIGN=center><a href='index.php?sort=NextEpisode'>Next Episode</a></TH>
	<TH  ALIGN=Center>Language</TH>
	<TH  ALIGN=center>Format</TH>
	<TH  ALIGN=Center>Search</TH>
	<TH  ALIGN=Center></TH>
	</TR>";

foreach ($xml->Show as $xmlShow) {
	$xml_sorted[] = new Show($xmlShow); # Add show object to the xml_sorted array
}

if ($_GET["sort"] == "Series") {
	usort($xml_sorted, array("Show", "cmp_name")); # sorted by showname
}
elseif ($_GET["sort"] == "NextEpisode") {
	usort($xml_sorted, array("Show", "cmp_date")); # sorted by next airdate

     foreach ($xml_sorted as $Show) #Makes sure that shows that have next airdate information are at the top of the list
     {
		if ($Show->Next == "Not posted" or $Show->Next == "Unknown")
		{
			array_push($xml_sorted, $xml_sorted[0]);
			array_shift($xml_sorted);
		}
     }
}
else {
	usort($xml_sorted, array("Show", "cmp_date")); # default sorted by next airdate
	
	foreach ($xml_sorted as $Show) #Makes sure that shows that have next airdate information are at the top of the list
     {
		if ($Show->Next == "Not posted" or $Show->Next == "Unknown")
		{
			array_push($xml_sorted, $xml_sorted[0]);
			array_shift($xml_sorted);
		}
     }
}


foreach ($xml_sorted as $Show)  {
        print "	<TR>
		<TD ALIGN=right> $Show->Name
		<TD ALIGN=center> $Show->Season x $Show->Episode
		<TD ALIGN=left> $Show->Next
		<TD ALIGN=center>";
        $language = $Show->Language;
        while ( $language > 0 ) {
                $language_start = $language;
                $language = (($language-1) & $language) ;
                if ($language_start-$language == 2 ) {
                        print "French ";
                } elseif ($language_start-$language == 4 ) {
                        print "German ";
                } elseif ($language_start-$language == 8 ) {
                        print "Spanish ";
                } elseif ($language_start-$language == 16) {
                        print "Danish ";
                } elseif ($language_start-$language == 32) {
                        print "Dutch ";
                } elseif ($language_start-$language == 64) {
                        print "Japanese ";
                } elseif ($language_start-$language == 128 ) {
                        print "Korean ";
                } elseif ($language_start-$language == 256 ) {
                        print "Russian ";
                } elseif ($language_start-$language == 512 ) {
                        print "Italian ";
                } elseif ($language_start-$language == 1024 ) {
                        print "Cantronese ";
                } elseif ($language_start-$language == 2048 ) {
                        print "Polish ";
                } elseif ($language_start-$language == 4096 ) {
                        print "English ";
                } elseif ($language_start-$language == 8192 ) {
                        print "Vietnamese ";
                } elseif ($language_start-$language == 16384 ) {
                        print "Swedish ";
                } elseif ($language_start-$language == 32768 ) {
                        print "Norwegian ";
                } elseif ($language_start-$language == 65536 ) {
                        print "Finish ";
                } elseif ($language_start-$language == 131072 ) {
                        print "Mandarin ";
                } elseif ($language_start-$language == 1073741824 ) {
                        print "Unknown ";
		}                
        }
	print "
		<TD ALIGN=center>";
	$format = $Show->Format;
	if ($format == 0 ) {
		print "Any ";
	} 
 	
	while ( $format > 0 ) {
		$format_start = $format;
		$format = (($format-1) & $format) ;
		if ($format_start-$format == 2 ) {
			print "DVD ";
		} elseif ($format_start-$format == 4 ) {
			print "SVCD ";
		} elseif ($format_start-$format == 8 ) {
			print "VCD ";
		} elseif ($format_start-$format == 16) {
			print "Xvid ";
		} elseif ($format_start-$format == 32) {
			print "HDts ";
		} elseif ($format_start-$format == 64) {
			print "WMV ";
		} elseif ($format_start-$format == 128 ) {
			print "Other ";
		} elseif ($format_start-$format == 256 ) {
			print "RatDVD ";
		} elseif ($format_start-$format == 512 ) {
			print "Ipod ";
		} elseif ($format_start-$format == 1024 ) {
			print "PSP ";
		} elseif ($format_start-$format == 131072 ) {
			print "x264 ";
		}
	}
	print "
		<TD ALIGN=center> $Show->SearchBy";
	print  ' 	
		<TD ALIGN=center>
			<form method=post action=index.php>
			<input TYPE="hidden" name=show VALUE="'; print stripslashes($Show->Name); print '"> 
			<input TYPE="hidden" name=season VALUE="'; print $Show->Season; print '"> 
			<input TYPE="hidden" name=episode VALUE="'; print $Show->Episode; print '"> 
			<input TYPE="hidden" name=format VALUE="'; print $Show->Format; print '"> 
			<input TYPE="hidden" name=language VALUE="'; print $Show->Language; print '"> 
			<input TYPE="hidden" name=searchby VALUE="'; print $Show->SearchBy; print '"> 
			<input TYPE="submit" name=action VALUE=Edit> </form> 
			</form>';
			
	print  ' 	
		<TD ALIGN=center>
			<form method=post action=index.php>
            <input TYPE="hidden" name=format VALUE="'; print $Show->Format; print '">
			<input TYPE="hidden" name=show VALUE="'; print $Show->Name; print '">
			<input TYPE="submit" name=action VALUE=Del> </form>
			</form>';
	print "</TR>";
}
print "</TABLE>";
print "<form method=post action=index.php>
      <input TYPE=\"submit\" name=action VALUE=\"Add Show\"> </form>
      </form>";
}

class Show {
    var $Name, $Season, $Episode, $Next, $Language, $Format, $SearchBy, $NextAirtimeFixed;

    function Show($xml)
    {
        $this->Name = $xml->Name;
		$this->Season = $xml->Season;
		$this->Episode = $xml->Episode;
		$this->Next = $xml->Next;
		$this->Language = $xml->Language;
		$this->Format = $xml->Format;
		$this->SearchBy = $xml->SearchBy;

		$this->NextAirtimeFixed = substr($xml->Next, -7, 2). substr($xml->Next, -11, 3). substr($xml->Next, -4). " ". substr($xml->Next, -20, 8); ##DayMonthYear Hour:Minute PM
		#print "<TD ALIGN=left> $this->NextAirtimeFixed";
		#08:00 pm Feb/07/2008
    }
	
    function cmp_name($a, $b) ## sort by show name
    {
        $al = strtolower($a->Name); ## Makes Show->Name all lowercase
        $bl = strtolower($b->Name);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }
	
	function cmp_date($a, $b) ## sort by future date
    {
        $al = strtotime($a->NextAirtimeFixed); 
        $bl = strtotime($b->NextAirtimeFixed);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }
}



?>
