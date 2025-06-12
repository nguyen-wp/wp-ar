"use strict";

/**
* @package MADELAB Theme 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/
// function redux_add_date() {
//     (function($){
//         'use strict';
//         $(document).ready(function(){
//             var date = new Date();
//             var text = $('#opt-blank-text');
//             text.val(date.toString());
//         });    
//     })(jQuery)    
// };
function made_core_backup_db() {
  // redirect to the backup page
  window.location.href = "admin.php?page=madelab-core-backup";
}

;

function made_core_restore_db() {
  // redirect to the restore page
  window.location.href = "admin.php?page=madelab-core-restore";
}

function made_core_rebuild_db() {
  // redirect to the rebuild page
  window.location.href = "admin.php?page=madelab-core-rebuild";
}

function made_core_compress() {
  // redirect to the rebuild page
  window.location.href = "admin.php?page=madelab-core-compress";
}