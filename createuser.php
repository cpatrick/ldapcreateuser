<?php

// Set these up to properly add
$bind_dn = "";
$bind_pw = "";
$directory_constraint = "";

$ds = ldap_connect("127.0.0.1");  // assuming the LDAP server is on this host

if ($ds) {

    // avoid protocal problems
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

    // bind with appropriate dn to give update access
    $r = ldap_bind($ds, $bind_dn, $bind_pw);

    // prepare data
    $info["objectclass"][0] = "top";
    $info["objectclass"][1] = "person";
    $info["objectclass"][2] = "inetOrgPerson";
    $info["sn"] = end(split(" ", $_POST['name']));
    $info["cn"] = $_POST['name'];
    $info["uid"] = $_POST['uid'];
    $info["userPassword"] = $_POST['password'];

    // add data to directory
    $r = ldap_add($ds, "cn=".$_POST['name'].$directory_constraint, $info);

    ldap_close($ds);
    header('Location: success.html');
} else {
    header('Location: failure.html');
}
?>
