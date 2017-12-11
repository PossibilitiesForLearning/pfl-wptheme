<?php

	function loadXMLDoc($xmlfile)
	{
	  $doc = new DOMDocument();
	  $doc->load($xmlfile);
	  return $doc;
	}

	function getSingleAttribValue($xmlfile,$tag,$attrib)
	{
	  return getXMLAttrib(loadXMLDoc($xmlfile)->getElementsByTagName($tag)->item(0),$attrib);
	}

	function getXMLNodeList($xmldoc,$nodename)
	{
	  return $xmldoc->getElementsByTagName( $nodename );
	}

	function getXMLAttrib($xmlnode,$attrib)
	{
	  return $xmlnode->getAttributeNode($attrib)->value;
	}

?>