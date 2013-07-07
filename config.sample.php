<?php
/* config.sample.php - DNS-WI
 * Copyright (C) 2013  OWNDNS project
 * http://owndns.me/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License 
 * along with this program. If not, see <http://www.gnu.org/licenses/>. 
 */
session_start();
ini_set('display_errors', 1);                         // only for development, will be removed later
ini_set('error_reporting', E_ALL);                    // only for development, will be removed later

$database               = array();                    // init database array
$database["typ"]        = "mysqli";                   // Database typ (available: mysql, mysqli and pgsql) 
$database["host"]       = "localhost";                // Database host
$database["user"]       = "mydns";                    // Database user
$database["pw"]         = "mydns";                    // Database password
$database["db"]         = "mydns";                    // MyDNS Database

$conf                   = array();                    // init config array
$conf["typearray"]      = array(                      // available record type
                                'A',                  // A record
                                'AAAA',               // AAAA record
                                'CNAME',              // CNAME record
                                'MX',                 // MX record
                                'NS',                 // NS record
                                'PTR',                // PTR record
                                'SRV',                // SRV record
                                'TXT'                 // TXT record
                               );
$conf["name"]           = "OWNDNS";            // Name of Page
$conf["soa"]            = "dns_soa";                  // SOA Table
$conf["rr"]             = "dns_rr";                   // RR Table
$conf["users"]          = "dns_users";                // Users Table
$conf["mbox"]           = "info.owndns.me.";          // mbox for SOA
$conf["soans"]          = "ns1.owndns.me.";           // NS for SOA
$conf["ns"]             = array(                      // NameServers for new zone
                                "ns1.owndns.me.",     // NS1
                                "ns2.owndns.me.",     // NS2
                                "ns3.owndns.me.",     // NS3
                                "ns4.owndns.me.",     // NS4
                                "ns5.owndns.me."      // NS5
                               );
$conf["a"]              = "127.0.0.1";                // A record for new zone
$conf["aaaa"]           = Null;                       // AAAA record for new zone
$conf["txt"]            = "v=spf1 mx -all";           // TXT record for new zone
$conf["ttl"]            = 86400;                      // TTL of soa record
$conf["refresh"]        = 28800;                      // Refresh of soa record
$conf["retry"]          = 7200;                       // Retry of soa record
$conf["expire"]         = 604800;                     // Expire of soa record
$conf["minimum_ttl"]    = 60;                         // Minimum ttl for some records
$conf["version"]        = "0.1.6-Beta";               // Version

require_once("lib/".$database["typ"].".class.php");
DB::connect($database["host"], $database["user"], $database["pw"], $database["db"]);
require_once("lib/func.class.php");
require_once("lib/dns.class.php");

?>
