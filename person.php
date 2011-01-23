<?php
require("hypem.class.php");
header("Content-Type: application/rss+xml");
$user = $_GET["user"];
echo '<?xml version="1.0" encoding="utf-8"?>';
$hypes = getUserLoved($user);
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
<channel>
<title><?php echo $user; ?>'s loved tracks - Hypem</title>
<link>http://hypem.com/</link>
<description><?php echo $user; ?>'s loved tracks</description>
<language>en</language>


		<generator>happylinks</generator>
		<ttl>60</ttl>
		<image>
			<url>http://happylinks.nl/hypem/img/hypem.png</url>
			<title><?php echo $user; ?>'s loved tracks - Hypem</title>
			<link>http://hypem.com/</link>
		</image>
		<itunes:author>Hypem.com</itunes:author>
		<itunes:summary>Discover music blogs worth listening to. Create your own music stream with your favorite artists, blogs &amp; friends.</itunes:summary>
		<itunes:owner>
			<itunes:name>Hypem.com</itunes:name>
			<itunes:email>contact@hypem.com</itunes:email>
		</itunes:owner>
		<itunes:image href="http://happylinks.nl/hypem/img/hypem.png" />
		<itunes:keywords>music,blogs,artists</itunes:keywords>
		<itunes:category text="Music">
		</itunes:category>
		<itunes:explicit>no</itunes:explicit>
<?php
foreach($hypes as $hype){
	$hype = getHypem($hype);
	echo "<item>
	";
		echo "<title>".$hype["artist"]." - ".$hype["song"]."</title>
		";
		echo "<link>".$hype["blog"]."</link>
		";
		echo "<pubDate>Wed, 19 Jan 2011 21:29:24 GMT</pubDate>
		";
		echo "<description><![CDATA[]]></description>
			<content:encoded><![CDATA[]]></content:encoded>";
		echo '<category domain="http://hypem.com/">Hypem</category>
			<dc:creator>Hypem</dc:creator> 
';
		echo "<guid isPermaLink='true'>".$hype["id"]."</guid>
		";
		echo "<itunes:explicit>no</itunes:explicit>
			<itunes:keywords>music,arists,blogs</itunes:keywords>
			<itunes:subtitle></itunes:subtitle>
			<itunes:author>Hypem</itunes:author>";
		echo "<enclosure url='".$hype["songurl"]."' type='audio/mpeg' length='".$hype["duration"]."000'/>
		";
	echo "</item>
	";
}
echo "</channel></rss>
";
?>