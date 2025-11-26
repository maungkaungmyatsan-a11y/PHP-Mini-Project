</body>
<!-- bootstrap link -->
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    function LoadFile(event){
    
        let output = document.getElementById("output");
         var reader = new FileReader();

         reader.onload = function(){
            output.src = reader.result;

            
         }
         reader.readAsDataURL(event.target.files[0])


    }
</script>
</html>