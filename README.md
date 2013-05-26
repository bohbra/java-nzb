JavaNZB
---------------

JavaNZB is java program that fetches NZB files from Newzbin whenever a
new episode for a show is aired according to www.tvrage.com, and drops them into a
queue directory for download.

Requirements
---------------

 * Java 1.6, but older versions may work.
 * A binary newsgroup downloader (ie SABnzbd, Hellanzb, GrabIt)
 * Newzbin account (www.newzbin.com)
 * Apache/PHP for the season pass manager, but you can just edit the series file manually if you wish.
 * SABnzbd for a slick web interface and probably the best newsgroup downloader out there.
   http://www.sabnzbd.org/

Usage
---------------

- Copy the files from the Web directory to your apache WEB directory and edit it to 
reflect the location of your series file.  Make sure that you chmod 777 your 
series file so as to allow the web application to update it.

- Copy the files in the Main directory to a dir of your choice.  I use the following:
/opt/JavaNZB

- You then need to edit the JavaNZB.config file and put in this information:
 * QueueDir - Location of where your binary newsgroup downloader queue directory is located
   Ex. Unix - /tmp/.hellanzb/nzb/daemon.queue
       Windows - C:\\tmp\\NzbQueueDir
 * Newzbin username and password


- After that is done you can open the index.php file using your browser and add
series you would like to download.  You can select more than one type of format
and language but be aware that it will only download the first one it sees.
So if you select DVD and XVID and the XVID comes out on top in the search it will
only download that one.  I suggest you duplicate an entry if you would like more
than one format.

- Next we run it by letting the crontab run the program every ten minutes:

- crontab -e
  */10 * * * *    /opt/JavaNZB/run.sh > /opt/JavaNZB/lastrun.log

- The web interface is sorted by earliest show release date by default, but if you click on "Series"
on the top left it will sort by name.  

There are many search options when adding a show, here are a few examples:

    ShowName Season x Episode - 
		This is the standard search type.  It will search "Lost 3x04".
	Showname SeriesNum - 
		Shows like Naruto are posted with series number which is the total number of episodes up to
		the latest.  It will search "Naruto 127".
	Showname YYYY-MM-DD - 
		Conan is an example of a show that uses this search method. "Conan 2008-02-18"
	Showname EpisodeTitle - 
		Mythbuster's episode number on newzbin is different than the one on TVrage, so this search
		is necessary. It will search "Mythbusters Viewers Special 2"

- Finally, sometimes shows have similar names and season/episode numbers.  For example, "House 4x04" might
bring up "Desperate Housewives 4x04".  One remedy is to edit the show name to "House -desperate" or you
can just use the Showname EpisodeTitle search type.

Changelog
---------------
* 0.7 (Sep 10, 2008)
-Using unicode format for reading/writing the series file because of foreign characters crashing the series file.
-Updated the search for the series episode number
-Appended format type to the nzb file to show differences in similar file types
-Updated PHP so editing/removing doesn't remove all other shows with the same name. (ie HD,Xvid versions)

* 0.6 (Mar 17, 2008)
-Removed unnecessary class constructor in xmlinfo
-Changed date roll function to add.  Roll doesn't increment year
-Only searches for new shows three hours before they air to avoid fakes

* 0.5 (Mar 14, 2008)
-Fixed bug with apostrophes when editing show information.

* 0.4 (Feb 14, 2008)
-Added new search 'Showname EpisodeTitle' (for shows like mythbusters)
-Updated PHP/Java for new search type
-Changed retention search from 100 days to 14 days
-Uses the replaceall() method (replace spaces with %20) when the query is completely built

* 0.3 (Feb 13, 2008)
-Renamed the project from prenominalport to JavaNZB
-Added config file that contains newzbin username/password and queue directory
-Renamed series file to JavaNZB.series
-Renamed config file to JavaNZB.config
-Updated PHP to reflect new series file name
-Added ReadConfig method that reads the config file and places the information into global strings

* 0.2 (Feb 1, 2008)
-Next episode title information gathered from tvrage with '&' is not recognized properly by PHP, so it is replaced by 'and'

