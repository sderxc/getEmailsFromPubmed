<?php
function getEmailsFromPubmed($query, $retmax = 100){

        $params = array(
            'db' => 'pubmed',
            'retmode' => 'xml',
            'retmax' => $retmax,
            'usehistory' => 'y',
            'term' => $query,
        );

        $xml = simplexml_load_file('http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?' . http_build_query($params));
        
        $params = array(
            'db' => 'pubmed',
            'retmode' => 'xml',
            'query_key' => (string) $xml->QueryKey,
            'WebEnv' => (string) $xml->WebEnv,
            'rettype' => 'full',
            'retmax' => $retmax,
        );

        $xml = simplexml_load_file('http://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?' . http_build_query($params));

        $xmlarray = $xml->asXML();

        preg_match_all( '/[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}/i', $xmlarray, $matches );
        $result = array_unique($matches[0]);
        foreach ($result as $res) {
            echo $res . '<hr>';
        }
}

?>
