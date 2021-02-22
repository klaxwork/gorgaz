page/default/index
<script>

    var x = document.cookie;
    console.log('x', x);

    $(document).ready(function () {
        //Cookies.set('_city', 'грод');
        //Cookies.remove('_city');

        var _city = Cookies.get('_city');
        console.log('_city', _city);

        var all = Cookies.get();
        console.log('all', all);

    });

</script>