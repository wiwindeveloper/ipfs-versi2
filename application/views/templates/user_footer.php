 <!-- Footer -->
 <footer class="sticky-footer">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; CWC 2021</span>
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel"><?= $this->lang->line('logout_title');?></h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body"><?= $this->lang->line('logout_content');?></div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= $this->lang->line('cancel');?></button>
                 <a class="btn btn-info" href="<?= base_url('auth/logout'); ?>"><?= $this->lang->line('logout');?></a>
             </div>
         </div>
     </div>
 </div>

  
 <?php if (uri_string() != 'user/news_announcement') : ?>
     <?php if ($user['role_id'] == 2) : ?>
         <?php if ($user['is_news'] == 0) : ?>
             <div id="modalNews" class="modal fade" data-keyboard="false" data-backdrop="static">
                 <div class="modal-dialog">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title"><?= $this->lang->line('news_notification');?></h5>
                         </div>
                         <div class="modal-body mx-auto">
                             <p><?= $this->lang->line('sub_news_notification');?></p>
                             <a href="<?= base_url('user/news_announcement'); ?>" class="btn btn-info text-center mx-auto w-100"><?= $this->lang->line('ok');?></a>
                         </div>
                     </div>
                 </div>
             </div>
         <?php endif ?>
     <?php endif ?>
 <?php endif ?>

 <div class="showNotif">

 </div>

 <input type="hidden" id="hdnSession" data-value="<?= $this->session->userdata('email'); ?>" />

 <!-- Bootstrap core JavaScript-->
 <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
 <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 <!-- Core plugin JavaScript-->
 <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

 <!-- Custom scripts for all pages-->
 <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

 <!-- Page level plugins -->
 <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>

 <!-- Page level custom scripts -->
 <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
 <script src="<?= base_url('assets/'); ?>js/demo/chart-pie-demo.js"></script>

 <!-- Sweet Alert -->
 <script src="<?= base_url('assets/'); ?>js/sweetalert2.all.min.js"></script>

 <!-- Custom Javascript -->
 <script src="<?= base_url('assets/'); ?>js/custom.js"></script>
 <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
 <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
 <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script language="javascript">
    //deposit fil
    $('#button-image-fil').click(function () {
        $("#proof-fil").trigger('click');
    })

    $("#proof-fil").change(function () {
        $('#val-fil').text(this.value.replace(/C:\\fakepath\\/i, ''))
        $('.customform-control').hide();
    })

    //deposit mtm
    $('#button-image-mtm').click(function () {
        $("#proof-mtm").trigger('click');
    })

    $("#proof-mtm").change(function () {
        $('#val-mtm').text(this.value.replace(/C:\\fakepath\\/i, ''))
        $('.customform-control').hide();
    })

    //deposit zenx
    $('#button-image-zenx').click(function () {
        $("#proof-zenx").trigger('click');
    })

    $("#proof-zenx").change(function () {
        $('#val-zenx').text(this.value.replace(/C:\\fakepath\\/i, ''))
        $('.customform-control').hide();
    })
    
    $(function() {
        $('#datepicker').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) { 
                function isDonePressed() {
                    return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
                }
                if (isDonePressed()){
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));

                    var x = document.getElementById("datepicker").value;

                    var url = '<?php echo base_url();?>admin/userBonusMonth';
                    
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {date: x},
                        error: function() {
                            alert('Something is wrong');
                        },
                        success: function(data) {
                            $('#showBonus').html(data);  
                        }
                    });
                }
            }
        });
    });

    //show network when click
    function reply_click(clicked_id)
    {
        var iduser      = clicked_id;
        var result      = '#result'+iduser;
        var idresult    = 'result'+iduser;
        var eDisplay    = document.getElementById(idresult);
        var level       = document.getElementById("sel1").value;

        if(eDisplay.className == 'hideNetwork')
        {
            if(level == '')
            {
                alert('Type limit level first !!!');
            }
            else if(level <= 0)
            {
                alert('Level must be greater than 0 !!!');
            }
            else
            {
                eDisplay.classList.remove('hideNetwork');
                eDisplay.classList.add("displayNetwork");
                document.getElementById(iduser).innerHTML = '<i class="fas fa-caret-up"></i>';

                $.ajax({
                    type: "POST",
                    url: "<?= base_url();?>admin/showDownline",
                    data: {
                        user: iduser, level: level
                    },
                    beforeSend: function() {
                        $('#loader').removeClass('hidden');
                    },
                    success: function(data) {
                        $('#loader').addClass('hidden');
                        $(result).html(data);
                    },
                    error: function(data) {
                        alert('error');
                    },
                    complete: function(){
                        $('#loader').addClass('hidden');
                    }
                });
            }

        }
        else if(eDisplay.className == 'displayNetwork')
        {
            eDisplay.classList.remove('displayNetwork');
            eDisplay.classList.add("hideNetwork");
            document.getElementById(iduser).innerHTML  =  '<i class="fas fa-caret-down"></i>';
        }
    }

    function reply_click_net(clicked_id)
    {
        var iduser      = clicked_id;
        var result      = '#result'+iduser;
        var idresult    = 'result'+iduser;
        var eDisplay    = document.getElementById(idresult);
        var level       = document.getElementById("sel1").value;

        if(eDisplay.className == 'hideNetwork')
        {
            if(level == '')
            {
                alert('<?= $this->lang->line('alert_limit_level'); ?> !');
            }
            else if(level <= 0)
            {
                alert('<?= $this->lang->line('alert_limit_level2'); ?>');
            }
            else
            {
                eDisplay.classList.remove('hideNetwork');
                eDisplay.classList.add("displayNetwork");
                document.getElementById(iduser).innerHTML = '<i class="fas fa-caret-up"></i>';
    
                $.ajax({
                    type: "POST",
                    url: "<?= base_url();?>user/showDownline",
                    data: {
                        user: iduser, level: level
                    },
                    beforeSend: function() {
                        $('#loader').removeClass('hidden');
                    },
                    success: function(data) {
                        $('#loader').addClass('hidden');
                        $(result).html(data);
                    },
                    error: function(data) {
                        alert('Something wrong');
                    },
                    complete: function(){
                        $('#loader').addClass('hidden');
                    }
                });
            }
        }
        else if(eDisplay.className == 'displayNetwork')
        {
            eDisplay.classList.remove('displayNetwork');
            eDisplay.classList.add("hideNetwork");
            document.getElementById(iduser).innerHTML  =  '<i class="fas fa-caret-down"></i>';
        }
    }

    //click sponsor
    function reply_click_user(clicked_id)
    {
        var iduser      = clicked_id;
        var result      = '#result'+iduser;
        var idresult    = 'result'+iduser;
        var eDisplay    = document.getElementById(idresult);
        var level       = document.getElementById("sel1").value;

        if(eDisplay.className == 'hideNetwork')
        {
            if(level == '')
            {
                alert('<?= $this->lang->line('alert_limit_level'); ?>');
            }
            else if(level <= 0)
            {
                alert('<?= $this->lang->line('alert_limit_level2'); ?>');
            }
            else
            {
                eDisplay.classList.remove('hideNetwork');
                eDisplay.classList.add("displayNetwork");
                document.getElementById(iduser).innerHTML = '<i class="fas fa-caret-up"></i>';
    
                $.ajax({
                    type: "POST",
                    url: "<?= base_url();?>user/showSponsorBottom",
                    data: {
                        user: iduser, level: level
                    },
    
                    success: function(data) {
                        $(result).html(data);
                    },
                    error: function(data) {
                        alert('error');
                    }
                });
            }

        }
        else if(eDisplay.className == 'displayNetwork')
        {
            eDisplay.classList.remove('displayNetwork');
            eDisplay.classList.add("hideNetwork");
            document.getElementById(iduser).innerHTML  =  '<i class="fas fa-caret-down"></i>';
        }
    }

    function reply_click_admin(clicked_id)
    {
        var iduser      = clicked_id;
        var result      = '#result'+iduser;
        var idresult    = 'result'+iduser;
        var eDisplay    = document.getElementById(idresult);

        if(eDisplay.className == 'hideNetwork')
        {
            eDisplay.classList.remove('hideNetwork');
            eDisplay.classList.add("displayNetwork");
            document.getElementById(iduser).innerHTML = '<i class="fas fa-caret-up"></i>';

            $.ajax({
                type: "POST",
                url: "<?= base_url();?>admin/showSponsorBottom",
                data: {
                    user: iduser
                },

                success: function(data) {
                    $(result).html(data);
                },
                error: function(data) {
                    alert('error');
                }
            });

        }
        else if(eDisplay.className == 'displayNetwork')
        {
            eDisplay.classList.remove('displayNetwork');
            eDisplay.classList.add("hideNetwork");
            document.getElementById(iduser).innerHTML  =  '<i class="fas fa-caret-down"></i>';
        }
    }

     // Enable pusher logging - don't include this in production
     Pusher.logToConsole = true;

     var pusher = new Pusher('375479f0c247cb7708d7', {
         cluster: 'ap1'
     });

     var channel  = pusher.subscribe('my-channel');
     var channel2 = pusher.subscribe('channel-auto-mining');
     var channel3 = pusher.subscribe('channel-basecamp');
     var channel4 = pusher.subscribe('channel-deposit');
     var channel5 = pusher.subscribe('channel-confirm-deposit');
     var channel6 = pusher.subscribe('channel-wd');

     channel.bind('my-event', function(data) {
         var show = data.message;
         var user = data.user;
         var email = data.email;
         var cart = data.cart;

         var sessionValue = $("#hdnSession").data('value');

         if (email == sessionValue) {
             xhr = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/modalNotification'); ?>",
                 data: {
                     item_id: show,
                     item_user: user,
                     item_cart: cart
                 },
                 success: function(response) {
                     $('.showNotif').html(response);
                     $("#notifModal").modal();
                 }
             });

             zhr = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/listNotification'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.list-notification').html(response);
                 }
             });
         }
     });

     channel3.bind('event-basecamp', function(data) {
         var show = data.message;
         var user = data.user;
         var email = data.email;

         var sessionValue = $("#hdnSession").data('value');

         if (email == sessionValue) {
             // alert(JSON.stringify(data));

             mdlbscmp = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/modalNotificationBasecamp'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.showNotif').html(response);
                     $("#notifBasecampModal").modal();
                 }
             });

             ntfbscmp = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/listNotification'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.list-notification').html(response);
                 }
             });
         }

     });

     channel4.bind('event-deposit', function(data) {
         var show = data.message;
         var user = data.user;
         var email = data.email;

         var sessionValue = $("#hdnSession").data('value');

         if (email == sessionValue) {
             mdldepo = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/modalNotificationDeposit'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.showNotif').html(response);
                     $("#notifDeposit").modal();
                 }
             });

             ntfdepo = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/listNotification'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.list-notification').html(response);
                 }
             });
         }

     });

     channel5.bind('event-confirm-deposit', function(data) {
         var show = data.message;
         var user = data.user;
         var email = data.email;

         var sessionValue = $("#hdnSession").data('value');

         if (email == sessionValue) {
             mdlcdepo = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/modalNotificationDeposit'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.showNotif').html(response);
                     $("#notifCDeposit").modal();
                 }
             });

             ntfcdepo = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/listNotification'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.list-notification').html(response);
                 }
             });
         }

     });

    channel6.bind('event-wd', function(data) {
        var show = data.message;
        var user = data.user;
        var email = data.email;

        var sessionValue = $("#hdnSession").data('value');

        if (email == sessionValue) {
            mdlcwd = $.ajax({
                method: "POST",
                url: "<?= base_url('Admin/modalNotificationWd'); ?>",
                data: {
                    item_id: show,
                    item_user: user
                },
                success: function(response) {
                    $('.showNotif').html(response);
                    $("#notifWd").modal();
                }
            });

            ntfcwd = $.ajax({
                 method: "POST",
                 url: "<?= base_url('Admin/listNotification'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.list-notification').html(response);
                 }
             });
        }
    });

     channel2.bind('event-auto-mining', function(data) {
         var show = data.message;
         var user = data.user;
         var email = data.email;

         var sessionValue = $("#hdnSession").data('value');

         if (email == sessionValue) {
             yhr = $.ajax({
                 method: "POST",
                 url: "<?= base_url('User/modalLimitMining'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.showNotif').html(response);
                     $("#notifMiningModal").modal();
                 }
             });

             whr = $.ajax({
                 method: "POST",
                 url: "<?= base_url('User/listNotification'); ?>",
                 data: {
                     item_id: show,
                     item_user: user
                 },
                 success: function(response) {
                     $('.list-notification').html(response);
                 }
             });
         }
     });
 </script>

 <script>
     //image preview
     function previewImg() {
         const image = document.querySelector('.image-name');
         const imageLabel = document.querySelector('.custom-file-label');

         imageLabel.textContent = image.files[0].name;
     }

     //  zoom tree
    //   let zoomArr = [0.25, 0.5, 0.75, 0.85, 0.9, 1, 1.2, 1.5, 1.8];


    //  var element = document.querySelector('.maindiv');
    //  let value = element.getBoundingClientRect().width / element.offsetWidth;

    //  let indexofArr = 4;
    //  handleChange = () => {
    //      let val = document.querySelector('#sel').value;
    //      val = Number(val)
    //      console.log('handle change selected value ', val);
    //      indexofArr = zoomArr.indexOf(val);
    //      console.log('Handle changes', indexofArr)
    //      element.style['transform'] = `scale(${val})`
    //  }

    //  document.querySelector('.zoomin').addEventListener('click', () => {
    //      console.log('value of index zoomin is', indexofArr)
    //      if (indexofArr < zoomArr.length - 1) {
    //          indexofArr += 1;
    //          value = zoomArr[indexofArr];
    //          document.querySelector('#sel').value = value
    //          // console.log('current value is',value)
    //          // console.log('scale value is',value)
    //          element.style['transform'] = `scale(${value})`
    //      }
    //  })

    //  document.querySelector('.zoomout').addEventListener('click', () => {
    //      console.log('value of index  zoom out is', indexofArr)
    //      if (indexofArr > 0) {
    //          indexofArr -= 1;
    //          value = zoomArr[indexofArr];
    //          document.querySelector('#sel').value = value
    //          // console.log('scale value is',value)
    //          element.style['transform'] = `scale(${value})`
    //      }
    //  })

     //  zoom tree
     const zoomElement = document.querySelector(".maindiv");
     let zoom = 1;
     const ZOOM_SPEED = 0.08;

     document.addEventListener("wheel", function(e) {
         if (e.deltaY > 0) {
             zoomElement.style.transform = `scale(${(zoom += ZOOM_SPEED)})`;
         } else {
             zoomElement.style.transform = `scale(${(zoom -= ZOOM_SPEED)})`;
         }
     });
     $('.tree').on('mousewheel DOMMouseScroll', function(e) {
         var e0 = e.originalEvent;
         var delta = e0.wheelDelta || -e0.detail;

         this.scrollTop += (delta < 0 ? 1 : -1) * 30;
         e.preventDefault();
     });
    
    //search scroll
    var input = document.getElementById("myInput");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) { 
            event.preventDefault();
            $('.name-network').removeClass('highlight');

            zoomElement.style.transform = `scale(${(1)})`;
            
            var x = document.getElementById("myInput").value; 
            var elmnt = document.getElementById(x);

            elmnt.scrollIntoView({behavior: "smooth", block: "center"});
            elmnt.classList.add("highlight");
        }
    });

    var input = document.getElementById("myInputMobile");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            $('.name-network').removeClass('highlight');

            zoomElement.style.transform = `scale(${(1)})`;
            
            var x = document.getElementById("myInputMobile").value; 
            var elmnt = document.getElementById(x);
            elmnt.scrollIntoView({behavior: "smooth", block: "center"});
            elmnt.classList.add("highlight");
        }
    });

     //  scroll tree
     const slider = document.querySelector("#tree");
     let isDown = false;
     let startX;
     let scrollLeft;

     slider.addEventListener("mousedown", e => {
         isDown = true;
         slider.classList.add("active");
         startX = e.pageX - slider.offsetLeft;
         scrollLeft = slider.scrollLeft;
     });
     slider.addEventListener("mouseleave", () => {
         isDown = false;
         slider.classList.remove("active");
     });
     slider.addEventListener("mouseup", () => {
         isDown = false;
         slider.classList.remove("active");
     });
     slider.addEventListener("mousemove", e => {
         if (!isDown) return;
         e.preventDefault();
         const x = e.pageX - slider.offsetLeft;
         const walk = x - startX;
         slider.scrollLeft = scrollLeft - walk;
     });
 </script>

 <script>
     $(document).ready(function() {
         $("#show_hide_password1 button").on('click', function(event) {
             event.preventDefault();
             if ($('#show_hide_password1 input').attr("type") == "text") {
                 $('#show_hide_password1 input').attr('type', 'password');
                 $('#show_hide_password1 i').addClass("fa-eye-slash");
                 $('#show_hide_password1 i').removeClass("fa-eye");
             } else if ($('#show_hide_password1 input').attr("type") == "password") {
                 $('#show_hide_password1 input').attr('type', 'text');
                 $('#show_hide_password1 i').addClass("fa-eye");
                 $('#show_hide_password1 i').removeClass("fa-eye-slash");
             }
         })

         $("#show_hide_password2 button").on('click', function(event) {
             event.preventDefault();
             if ($('#show_hide_password2 input').attr("type") == "text") {
                 $('#show_hide_password2 input').attr('type', 'password');
                 $('#show_hide_password2 i').addClass("fa-eye-slash");
                 $('#show_hide_password2 i').removeClass("fa-eye");
             } else if ($('#show_hide_password2 input').attr("type") == "password") {
                 $('#show_hide_password2 input').attr('type', 'text');
                 $('#show_hide_password2 i').addClass("fa-eye");
                 $('#show_hide_password2 i').removeClass("fa-eye-slash");
             }
         })

         $("#show_hide_password button").on('click', function(event) {
             event.preventDefault();
             if ($('#show_hide_password input').attr("type") == "text") {
                 $('#show_hide_password input').attr('type', 'password');
                 $('#show_hide_password i').addClass("fa-eye-slash");
                 $('#show_hide_password i').removeClass("fa-eye");
             } else if ($('#show_hide_password input').attr("type") == "password") {
                 $('#show_hide_password input').attr('type', 'text');
                 $('#show_hide_password i').addClass("fa-eye");
                 $('#show_hide_password i').removeClass("fa-eye-slash");
             }
         })
     })
 </script>

 <!-- refresh message -->
 <script>
     setInterval("my_function();", 3000);

     function my_function() {
         $('#element').load(location.href + ' #msg');
     }
 </script>

 <script type="text/javascript">
     function custom_template(obj) {
         var data = $(obj.element).data();
         if (data && data['img_src']) {
             img_src = data['img_src'];
             template = $("<div><img src=\"" + img_src + "\" class=\"flag-option\"/></div>");
             return template;
         }
     }
     var options = {
         'templateSelection': custom_template,
         'templateResult': custom_template,
     }
     $('#id_select2_example').select2(options);
     $('.select2-container--default .select2-selection--single').css({
         'height': 'auto'
     });
 </script>

 <!-- withdrawal -->
 <script>
     $(document).ready(function() {
         $("#fee, #amount").keyup(function() {
             var amount = $("#amount").val();
             if (document.getElementById("coinType").value == 'filecoin') {
                 var fee = parseFloat(amount) * <?= $fee_withdrawal['fee_filecoin'] / 100 ?>;
                 $("#fee").val(fee.toFixed(10));
             } else if (document.getElementById("coinType").value == 'mtm') {
                 var fee = parseFloat(amount) * <?= $fee_withdrawal['fee_mtm'] / 100 ?>;
                 $("#fee").val(fee.toFixed(10));
             } else if (document.getElementById("coinType").value == 'zenx') {
                 var fee = parseFloat(amount) * <?= $fee_withdrawal['fee_zenx'] / 100 ?>;
                 $("#fee").val(fee.toFixed(10));
             }
             var total = parseFloat(amount) - parseFloat(fee);
             $("#total").val(total.toFixed(10));
         });
     });
 </script>

 <!-- package purchase -->
 <script>
     // Add active class to the current button (highlight it)
     var header = document.getElementById("coinPurchase");
     var btns = header.getElementsByClassName("btn-purchase");
     for (var i = 0; i < btns.length; i++) {
         btns[i].addEventListener("click", function() {
             var current = document.getElementsByClassName("active");
             current[0].className = current[0].className.replace(" active", "");
             this.className += " active";
         });
     }

     function changeMTM() {
         var balance_mtm = <?= $general_balance_mtm + 0 ?>;
         var price = <?= $price_mtm ?>;
         document.getElementById("price").value = price + " MTM";
         document.getElementById("balance").value = balance_mtm.toFixed(10) + " MTM";
         document.getElementById("coinType").value = "mtm";

         if (balance_mtm < price) {
             document.getElementById("lowBalance").innerHTML = "<small class='text-danger pt-1'><?= $this->lang->line('low_balance');?></small>";
             document.getElementById("btnBuy").disabled = true;
         } else {
             document.getElementById("lowBalance").innerHTML = "";
             document.getElementById("btnBuy").disabled = false;
         }
     }

     function changeFIL() {
         var balance_fil = <?= $general_balance_fil + 0 ?>;
         var price = <?= $price_fil ?>;

         document.getElementById("price").value = price + " FIL";
         document.getElementById("balance").value = balance_fil.toFixed(10) + " FIL";
         document.getElementById("coinType").value = "fil";

         if (balance_fil < price) {
             document.getElementById("lowBalance").innerHTML = "<small class='text-danger pt-1'><?= $this->lang->line('low_balance');?></small>";
             document.getElementById("btnBuy").disabled = true;
         } else {
             document.getElementById("lowBalance").innerHTML = "";
             document.getElementById("btnBuy").disabled = false;
         }

     }

     function changeZENX() {
         var balance_zenx = <?= $general_balance_zenx + 0 ?>;
         var price = <?= $price_zenx ?>;

         document.getElementById("price").value = <?= $price_zenx ?> + " ZENX";
         document.getElementById("balance").value = balance_zenx.toFixed(10) + " ZENX";
         document.getElementById("coinType").value = "zenx";

         if (balance_zenx < price) {
             document.getElementById("lowBalance").innerHTML = "<small class='text-danger pt-1'><?= $this->lang->line('low_balance');?></small>";
             document.getElementById("btnBuy").disabled = true;
         } else {
             document.getElementById("lowBalance").innerHTML = "";
             document.getElementById("btnBuy").disabled = false;
         }
     }

     
 </script>
 <script>
     function changeUSDT() {
         var balance_usdt = <?= $general_balance_usdt + 0 ?>;
         var price = <?= $price_usdt ?>;

         document.getElementById("price").value = <?= $price_usdt ?> + " USDT";
         document.getElementById("balance").value = balance_usdt.toFixed(10) + " USDT";
         document.getElementById("coinType").value = "usdt";

         if (balance_usdt < price) {
             document.getElementById("lowBalance").innerHTML = "<small class='text-danger pt-1'><?= $this->lang->line('low_balance');?></small>";
             document.getElementById("btnBuy").disabled = true;
         } else {
             document.getElementById("lowBalance").innerHTML = "";
             document.getElementById("btnBuy").disabled = false;
         }
     }
 </script>

 <script>
     $(document).ready(function() {
         $("#mtm, #filecoin").keyup(function() {
             var fil = $("#filecoin").val();
             var mtm = parseFloat(fil) / 4;
             $("#mtm").val(mtm);
         });
     });
 </script>

 <!-- notif user -->
 <script>
     $(document).ready(function() {
         $("#modalNote").modal('show');
     });
     $(window).on('load', function() {
         var width = $(window).width();
         if (width <= 480) {
             if ($.cookie('pop') != 1) {
                 $('#modalBanner').modal('show');
             }
             $(".nothanks").click(function() {
                 $.cookie('pop', '1');
             });
         }
     });
 </script>

 <script>
     function csImage(element) {
         document.getElementById("img_cs").src = element.src;
         document.getElementById("modal_cs_img").style.display = "block";
     }
 </script>

<script>
     $(document).ready(function() {
         $("#modalNews").modal('show');
     });
 </script>

 </body>

 </html>