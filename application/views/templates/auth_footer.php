<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password1 button").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password1 input').attr("type") == "text"){
                    $('#show_hide_password1 input').attr('type', 'password');
                    $('#show_hide_password1 i').addClass("fa-eye-slash");
                    $('#show_hide_password1 i').removeClass("fa-eye");
                }else if($('#show_hide_password1 input').attr("type") == "password"){
                    $('#show_hide_password1 input').attr('type', 'text');
                    $('#show_hide_password1 i').addClass("fa-eye");
                    $('#show_hide_password1 i').removeClass("fa-eye-slash");
                }
            })

            $("#show_hide_password2 button").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password2 input').attr("type") == "text"){
                    $('#show_hide_password2 input').attr('type', 'password');
                    $('#show_hide_password2 i').addClass("fa-eye-slash");
                    $('#show_hide_password2 i').removeClass("fa-eye");
                }else if($('#show_hide_password2 input').attr("type") == "password"){
                    $('#show_hide_password2 input').attr('type', 'text');
                    $('#show_hide_password2 i').addClass("fa-eye");
                    $('#show_hide_password2 i').removeClass("fa-eye-slash");
                }
            })
        })
    </script>
    
    <script>
        // refresh message
        setInterval("my_function();", 3000);
    
        function my_function() {
            $('#element').load(location.href + ' #msg');
        }
    
        function csImage(element) {
            document.getElementById("img_cs").src = element.src;
            document.getElementById("modal_cs_img").style.display = "block";
        }
</script>
    
</body>

</html>