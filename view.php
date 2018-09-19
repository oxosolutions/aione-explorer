<?php 
$page_title="View";
$view_class = "active";
include('templates/html-start.php'); 

$action = $_REQUEST['action'];
$type = $_REQUEST['type'];
$id = $_REQUEST['id'];

$url = '';
if(isset($action) && $action == "view"):
    $domains = $db->select('SELECT * FROM as_domains');
    $links = $db->select('SELECT * FROM as_links');

    foreach ($links as $key => $link) {
        if($type == 'link' && $id == $link['id']){
            $url = $link['link'];
        }
    }
    foreach ($domains as $key => $domain) {
        if($type == 'domain' && $id == $domain['id']){
            $url = $domain['domain_url'];
        }
    }
endif;
if(!empty($url)):
?>

<section class="view">
    <iframe src="<?php echo $url;?>" width="100%" height="600" frameborder="0"></iframe>
</section>

<?php 
endif;
include('templates/html-end.php'); ?>