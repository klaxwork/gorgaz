<?php

use common\components\M;

$storage = \Yii::getAlias('@storage');
M::printr($storage, '$storage');

$filename = 'sova.jpg';
M::printr($filename, '$filename');

$pattern = '/^data:image\/(jpeg|jpg|png);base64,/';
$fullImgStr = '<img src="data:image/jpeg;base64,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">';
M::printr($fullImgStr, '$fullImgStr');

$fullBase64 = 'data:image/jpeg;base64,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';
$shortBase64 = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEhUTExIVFhUVFxUYGBYWFRgXFhcXFRcXGBUXFhUYHyggGBolGxUVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OFw8PFSsdHSArNi03LS0tLS0tMistMistKy03LystKy03MS4tLSsrKysrKystNDEtLSstLS0tLSsrLf/AABEIAMQBAQMBIgACEQEDEQH/xAAbAAACAwEBAQAAAAAAAAAAAAADBAABAgUGB//EADoQAAEDAgQEAwcDAwIHAAAAAAEAAhEDIQQSMUEFUWFxIoGREzKhscHR8AZC4RRS8SNiFXKCkqKy0v/EABkBAQEBAQEBAAAAAAAAAAAAAAABAgQDBf/EACYRAQACAgIABQQDAAAAAAAAAAABAgMRBBITITFBUSJhkeEUFTL/2gAMAwEAAhEDEQA/APhytUrQRRRaAQQK1FYCCALUKwFoNQYVwthq0GIB5VYajtYN1osGyBcU1oUTyRhV8vJQjqgEKPMwrNAc1sAnU/dDLSgyKMqnUSE1hn7FaqoOeWKoTxZuVrM3kg50KQnqj2cpWGsaf2nvKBRRMf045rDqDhsgCpC1CqEGSFQC2qQVCqFtUgwotqigyooogiiisIIAtKK5QQLSgIRGwgjQiCmVuiRzR0AAIW3G2iw5w3HnKpp22QYLwrNT0RxhG227/dDfRA7c0AC6Vtj41usFSEDTtJ5JdxKKyoAOqzTE2hBKDTMhFqGCsCpsFguPZBp0ndU+nCy0LVzzQChaGn0VuYRdRoB3jylBQctvq2081RI2+OqIKJImbIAF87LL6ZGyaFNump5DVOtpgCI9UHGyqezK6VWkB5pd5iOW0aoFMhVQjFpKFCDMKoW1RCDKiuFEA1FYWkGFFvKoKaDIK2HLJbCgKAgKMyoBul5VhA5/ULLqwOyC1spilSbvrZAEPJ0WwTrtp0WqtMAwr9hIkGTyi/8AKAcD8uitZa4vsZ1QhPJaa8gdDt8kGWtR8O2DP+JVOpmJn86rLQeaDToGm3xQgwuIGsolQRui0myAR+2deR/wgE+jBM7KMPJTEOkk6yVhgiCg3eyNRaDsB5x6Lb6hO1zuLcvsrxZcIblOnlf6oMGgAbfNMBjOflM36LlOc7mB5oYeUHaz0mXGvxSNXiEgiPoki5YlAV1YrBqFYUCDUlW0FbZSlEFOEAgFRCMQsEIBwotQogAFoLIWgg0E0xtkvRZKcY2ECtViXK6bmiLrBw0mwQIslaIT39OBYdEvVpXsgE1y21x5oZctMdF1Q3SpHvG2xWqLspvZO4CmwgEuAkidY3mw8kTHUGsAfeZtyMc1AjimAQQRO/khwN5k3/x6o7agLYIFtOe0zzR20mvboZ/bAEWmZ/NkAaIDzlGvU8livTDTb8/Porsx0tIJibbG4IXQxWHD2moG6Btps0SQNd/d9UHLZSzSb2E9B1Kqm/rY6jn+SmKNIauG9ukafX0W8SMwDgRAm1rC1+m6BWpS0NkehhmgFzzGXY6u7DtKEAJteYhPVg5zcrGuAsHA6ZuQ73QApYhodOUEToUtjcSHWE5RK6r8I2jTFSPFoWnQ2v8ANcHE1GmMoI1168uiDNRw2WCJNrLCLFxBB0/lBdSleLHqEIsOieGWCY31+H55JrBYebRbveTofhog4/sioxi7FTBESTflG/n9EBtEC46d4QBZT80GqCDIsnvZ8uZVGmSIsECzTIWXK6lvqsygpWoogUC2sgLYQNYc2TACBh2QmAgjQjkgCOfxVUmmfot1zNvJAuRmtrHw5EIVTBkALoNpAbXHL7psCR7p7wd+sQg81UoQhPaQuxXpEuIFue/+EGrRyj3bxILgboB8NxAab2HaQOsfHyXosVhm1GyHgiBB3JjeF5hw307H7L0nAa5ibOAHSRf59UHPFKmx7qdURMQSfdnr+aKsRRFMFmaZgy3SYuJ/NQnuP4MueHNaSYl06GTYD1CQ4RU8Qm8OAylsg2Op/bpqgrCku0YSef8Ayxr/ANw9Ss18W+zS4wNuX3VVnPpz4XNGadxe8EH80W+D0DVqQd5knQHWTHY+qo2/Cva1r4kOmCD5mfQ/FDdTfUMNYSdIaO508iu9i8M7w08piDEgNcZ0AB08Ri0qYej/AEzXNzkVchLQCMoJuWzuBf0KaHKo1SxkgeKDeNiLA77T5KcNwNQ1MwaXBtyYgcxc6G3wQsLTqPe0ODr+K9iWg6wReCTbqV6zg7XMlgPjD7uY4Zp6t5WHwsoPNfqhz2eB+rjmjnI1jpp5LztQAaEnvZep/UtMZyXPzRN9803aB31XmAwG8oBNkotOg4mwO/ayPRwbjcCQB+Sn8JGYAMdm3JcPgGiwQBw/DnxMHvHy5IjGup7Wvfe9l6VgY4ZuVoFgO0nXqksTQa4HKD9e90EoeMXjT+JI5rnVMOASPMK+G1MtSHTN9d5/lO4uAZDb/k/JBz8pmfkgV2CNevqnXOiJ6xzQakHy+qDmFoCGCE3UpCyqpSBHVArKiN7M8h6qIEgi0BdCCNQ1QNtRWHRYaFbInmgZpOsTsPpqsYUZieQVg2PkphmeHQX67oGw2B7yVxdcDQfD+U0zOIFh53S2IpTuSUC1GuBqYHmZ/wCndNPyvBcRVIG4gCNrGb6pWvh4yOIgZoPPW31Xs38DBpy3dp+Ij6rl5HJjDNYn3dfG43jVtMezyWGwAqtLqYqkAxZofoJMhpkAS28QjcKrCjULX+6bOInM0zElp5bg/BcvDPfRqAg5XsOu4IRsPRdWrACMziSYEW3sNAuu0xFezkiJm3V9IbgiKYyuBFjaCCDB9DHmFwcRwpjGue0w5wImDa2ltJuPIrHDca7AuFOvJoPsI1YZmRG2tvsvRvwjT4g45CQ6Re+rTe41P5ril4vHavnDd6WpbraNS8thsCwyXPcZAAEZtvedJEco25olDA+zNTK1hdAkFpMADUDaTN+kLp4um0uDGtuTmEgwZ964035RlQcVh3DxSXAQBFzzDiBvvodD562xopjiwCmQ1z8rmuLmukFsGQBykgSdgFdSnTqF7ycjqcH/AFMs3BLY2JdLjECMo5roYbhr6jpkAaSQMwiSCHHztAidbIg4e2pWEhrsxaS5oglrWmSToQTlvdXZprh+APsWOBA8IBfN8ocTJ5uM69SjYctADqpDMgzCWgZRoDJFjt6o+LwzKLBlDW5QMznC4YOmt7WleI4pxSrjahuRSZ7rdB3IG6xa0RG5apWbTqCfHMVTqVHeztTB1dq47kannbqkcP7H9xqH/lAAnuT9F0MG6jTNcVQCfYubTBYXAPcLOEHwuFoJkXOliubRxLmWB8OZri06EsnLI8yPNbr5xE/LNvKdOphXMYTGfJoQ8aTzylTElouCehabH86rv8HpVMVS9pUOYmR6GLeg9F5zG4HLWe28CHeR+q5cXIi+S2P3h2ZeL0w1zfJnAYpxIkl0bFdYVamsBrTyN/kFy8BhYduOx/hds0OTnW2/g6rpcbz+Now7MBrqZ59PunS6W3ERF+nJax2HF5fHMRr16FApktMQcp/3TeNwdbINOgX2NvslatIHyJVtaIHMeLuO6rMPugScy/wCovixTDwBfl9UtWbOiCKLGTuopuQkj4bdACYotsqGWuW6YhZYERoB1QM0hIHJXRYQIACxQPxWn1MtxGqBoZzpHohvkEgnylWXztM3v9lMpN/oLIDsaH0ywtEdCJ/yvQfp3iwY32Ncjw2D/wBruUnY6WK8xTeWmR5GU/RxDXDX1+kXXhyeNTPTrb8vfj8i2G26vR8V/SuHxJDxLXHVzCL9wbHumOHcDwmDbMw46ucZeegA26ALy9R7WaVMvSBPrdI43H2IzwOUkTMagQD2XB/XZZr4ds89fjX7dP8AMxxbvGP6hv1nxVtU5QMoGjT7zurv7B017Lo/pbE1DRDT7gFvsDyjZeTpYc1XANYSN+oXfo5mENGZslouY0O+8T2X0sWKuKkUp6Q48uW2W03t6urW4blPtAXua6CWMyw0ib3HL5pXDUMgaWtrBs3c95/+YjqBK7dEAtHsnwRa8GS3UjtJuuF+ouKh7vZsYARZ1vCezRreSvR5uxh6dIAvqOY4f2sdlbewzuJGb0G6d4eXQ4tDWtjQeJzwJtEANEknU3PkuV+nsXTgU3kZhEAtEEa7aac118ZiWsJa2S50OMQJ1EAnXTRB539a4o+yblgNPQy7vaBHfcrjfpQt9xwgm4/3NO47Lt8Va17DBLQHOGUjwlptZpPTSd14nDVX03ZRs6Y5ETcHUFeefF4lJr6PfjZvByRfW3p/1H+m6jv9SiM1vE3c8iOfZcXh/wCn8TUdHsywTdzxAHkbnsF6rhfHKhEOpl1gZETGkn+70C6H/FiYimZ0uCL+k7L51b83FXpFIn7u22PiZb9++vsdwmGbQpBg0aABO/U/PzXh6zXVKj6rbioYHSmwgA+cErvY0V6+oOUzLRaw1km8dIHfZYZTDBDfecJcSNCPkOmi9eBxb4ptkyT9Us87l0yVrixf5gDBYKLyR3gg9eiNWY4WMEdRGnbVMgENl0zz2PUcvRKVnPiQAYkjfzn+F9B81xuJy514gaED6qqEhl5ienXcKjXznaTvz7BXp4bnc9LGEGKjhztt0HKEvVbM36eSI+pIabDbLohVHiSgXcHCeSFUbqR/lGLxNkvUqEahBPbO5KIftzyVIABMYfRLhHpIDhy2wg2OiyGrWVAzQeDoPNNFmbX8KWpW01+CdoN3PwQW1kRrpqtZO3c3RPZXB57fWVHX3J+XpugVNBxuI8zbyWmYEmJjv9k9SojXXcT+WW3MM+Ix0gme6BKlQYDHhA5kGP8AxcPkuhhuGUSJaWOI6785Nys1KrgLA9jotYfFOGrgOkfW6A+FwjQYz5TybFu5j7qsZg5ILRmggNDjsBcnoOS6fCMsXEiSSYsOdkfGUA1zYtMADlJ38zP/AEnmg5eOYadJr5gMcWmfQk97pjD8Jawe0Fy65Fybc469Lon6ppj+nLItn9ZaY+OZV+msR7SkRVn/AE2sabxJvJ7lUJcV4VH+qwBrGiXODrXPl2hP4rhrXBjrlsag3EgmZ30jzXL4xiXOcygHRTzgvFrgAFov1BPdeqptL2NJsLEgcjAaPSfVB500yGQWDwyMtjbYHeQREiNVysfwRryHU5aDd07HruNOS9PiMprOLQZcMttDGoc28uB+B6JXiLAw2YCHC4iOzm8tJidgR0SEcP8Ap17GioHkb3Ei+9jB9F0XBwjwtfzIIHw/NFTeLuawUxJMHxA8tiI1uP5VUxWMOcS7nYA+fNQBxNWrZoyi9ufxIiyJhMAdJcYEmbieRm66TKbXATIPI3Ex5karbaEaG8X1mBawMoEDQgakEW5ba8jskKrg25jtOUxzXf8AZmPFl6SOdxedFz8VgBGY63MbDmAe/JB5mph/ECBrPeBefklar3Ceu4N/DoYXWfgnN231m+65eIoEOEm8nr8dUCVUO1MOnS0OEob5v+HqivLhre8X2+qE4XttzQYMTZDqKOuJO+iCXEdR8kBPZt5K0L245FUgAEekgtRqaApKJSCFKM0oGaTfnun6Qnf86JFrtk2KkdrIG81gBJPy6oIdl0HX01QatSTlANz4iOXJMuGwAk6g8t/RA0yq2ATEkaLTaoJsfISZJSn9LzJ0/G5fS6dwmFJmSRGw0tzP0QBNAPMT5QZ+EIjOHEHwhwi5BFyOYM3/AJT+GswkgXmNj6GQUTDU3sF3OdqRYaeXyQM8OeAwg+8TlH2Wmw+vP7aXzGY/CfmgsYXtzAmfkZjySrs9CY3n+UG+P4oPaW8pHSQ77SscFxTW0asxmN/mR81xcVVzGCYzH4pOhii3M09iqHamKDnyReW/CPsvU4biQzATaWtGm2vyXga2IIE/krocOxbgW3sJcT1NvTVSR7LIG1iZsW338Q382geq4fEsblqNZqIgjvHpcfNW7E1KhhoM8/UfUphmDDJe4TAu5xgb2FiUA8HgKjiCGw21ybkD6aLrMoOGVruczrrpy6pvC48U4MEggSZNvXUdZRnYkHNBBnxDxZZHUmZCBJ2JyhuWNSLiNdhyvA9OqNTeYJIgtN80AjMbGdvPkhPe2HB4gG1zcEgxt31KRxGMFRhYHH2n73BuUhoOsZjJtMSg6/8AVNMMlrpMSCe4N9e3Rc/ihLWB0yW/umGze5GsdlzH4lpyte6XC05T4sobDhB72+yZdiCGlrzm/wBxkOHMhp0FggRPEG+67axka2mx5JLEEQCN9twD80tjQARmaMsnMQZMHS3dJ+xtmY4zzH1QFc0OmDPdL1Kd/LzQvaGb2d80R9aPNAs5vwSpc3Se6dqOBSVZgKAeVqtY9geatFZaitQWlFBRBGBMUggNumG2QFpQCtuxF7apNlWZKxmE3Hn3QdPNF5iBY9USjjXMu7SwG5Eyb80mDYCZG/1RS0l7XRIbJjl19fkg7OFBIMtvMWHT3iDoOnRdNmEIDQHWJ0tryGb5JPB4gOAJM33AuRFhyv8AIroUK7S6DcjUkzA1JnYW80ErtdDXAkNgm4u6I280SnixULYy5os3cjkRogPpgxLiGu0BDt9wew1QcXjTTJc0ZoAETFzoJ5JKw7FOqB+2Hbtm51iOa3iXNeAI+v8Ahedw3FXOeBVpCSLxOokaxa0bpp+MDD7tWo2TBbldkvdpJiY6qbNA8W4ZLSWjS/UHouFxsDLTeIzEePnNtV6Wnj2vzRNvI77H5Lzf6iYQWxo75/hViUmCGQvc1g1Nz+eq9hwzgwAvcmPvqk+D4dtIF7h4tzG3cptvEK9R+Wi2Gx7zjAB52ue28psdR1AMIjXSIuJ3gXv1I8lRxVNhDYkibwYBHbW5FuaoYdrL1ahcQL3DW5ju1g/9j9UhhKrHVSWDSJMa3u7tr+BQdmviiDZlsux8IdG/TUaJapXL2+E+Ej+6BJNhE2/dtsu4cFScz3RFrgDbqUlxMNoAVGEWs4ETIOsDmtDjcA4g45qdYXaSM7W++4akkbq8fwz2JNVgBMzJvbfTXVc1vF2ZiQ3W8tgQTBsOWoXXbjvaUxNgYMTy5cgpMkF8TRZVDSRcXkWm38BLY9xLbHxQQCb8k1iXiOkLz2IxcHufTmsxaVmC1XFObdwjYiJ317Qs0ajSfDY3sNETEhrhr25Lil0HkQtROx0cXRBuLFLZ5kHUfTdEo4oEX1VvU2hamDr6oFd10Z9TKT1HxSZlxVFe0Kiv2R5KKbGQVsFDWgqGaRRHOslGlFc63ogLSEBYb707fNamyHKDosd0WqxBERulG1YGqqnVk/nmg6NTEloa0a7dNBPQ3K9HwajlbDoOZxuL/wCN15qiJPpdd/B1msv0sNoHRUNPwTnVDUe4wZyCJaAUhxXGZcrG3M356XhPHiAcCSbQf5XnGV5e53w6fkIOjgq5BcyYbYzEX/dPInXyKNw7EPZDSZuYMiY77zPwXFdiXPsDYzfdFxdQMblg2+XTupKo5zxXdlcYuQJuJ2/hdelVgTUALpkADMZ5gbd1xcI8Oc1zbkASSdHDefJdGs5hBgn2h8UnbSw+PxU0bY4liiLk6/3GTzhrY8Kzw2m8tNSo6o4agSbfXRIMBzZ6hJJ0A5ax0sujTxTjmy+5E5TpYXnmrpNmMDRDm1SLtabkuMaRLjqe06LLsO5j8zCXNAAdsOhjbUJLg8tJcYMt02vpbbUL0FPKBEAE3JBntP5ukzqFh06mMc2nJFspa7U6Awb9QF57iPERVpEFx5iNiNJldarVDmwev58F43EAsc5p2MHqpFtrMGOAuY2pDzY6HrsnsZiwDDTa0ei84+oQVdXFFxkm9vgtSy9B/wAQLmwNoXA4pU8Wuv4VKdciYKUxNQuWYhZHw2INt+amMbm8W/LmlMO8AwUV+Ig2V0jOGmU2KmoQhBuN0Fz4OvkoM1XkoXZWHLKo37U9FEOFaCgrlUFaDTUQ+8ggqZ7IGS6VRQaZWq7rILe+yrDv35obnWWqNyg6+GqQEWhXJbJ3SGa0LTakCEB3Y22ulkv7S0c/wpbFHRBdUsEHZw9UATuFjE1M5ibAXXJZWMRKLSqGYQdfh1YNBEdZUw7xmnYfFINehtq5UiQ9icUI03t2KqrjQGQNyRrsFzMRU0QS4qjucIxPiJ6D6fYLqf1sLzWDfAlFdiFiY3K7d9/EUviqgfB3HxXEOIRBirJo2YxzBAI/OqQJTJq5hdBstIYoWCSxIh3JEbVWahmyBcqnOlbAQ3ID4WpeFVR9yh0nQiZUGCqUcIVSg0oqVoMhWrUQUdFhRRBumbqVFFEGQjUlFEBpUzKKIMvShKiiC0Whuoog2HLDioooBkrKiioOw2WJUUQZJWmlRRBtjlp5UUQAcUQFUogzKh0VqIBhHLlFEEBVEKlEFKKKIP/Z';
$base64 = $fullBase64;
M::printr($base64, '$base64');

$preg = preg_replace($pattern, '', $base64);
M::printr($preg, '$preg');

$source = base64_decode($preg);
//M::printr($source);

$systemFilename = "{$storage}/{$filename}";
$f = fopen($systemFilename, 'w');
fputs($f, $source);
fclose($f);

print "<img src='/store/{$filename}'>";

$source = '';

$systemFilename = "{$storage}/{$filename}";
$systemFilename = "{$storage}/sova_original.jpg";
$f = fopen($systemFilename, 'r');
$tm_start = microtime(true);
while (!feof($f)) {
    $tm_stop = microtime(true);
    if ($tm_stop - $tm_start > 5) exit;
    $s = fgets($f, 512);
    $source .= $s;
}
fclose($f);

$base64 = base64_encode($source);
M::printr($base64, '$base64');
exit;


if (0) {
    $cs = Yii::app()->clientScript;
    $themePath = Yii::app()->theme->baseUrl;

    $cs->registerCssFile($themePath . '/assets/admin-tools/admin-forms/css/admin-forms.css');
    $cs->registerCssFile($themePath . '/vendor/plugins/magnific/magnific-popup.css');
    $cs->registerScriptFile($themePath . '/vendor/plugins/magnific/jquery.magnific-popup.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/jquerymask/jquery.maskedinput.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/jquery/jquery_ui/jquery-ui.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/liTranslit/js/jquery.liTranslit.js', CClientScript::POS_END);
    $cs->registerCssFile($themePath . '/vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css');
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/jquery.fancytree-all.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.childcounter.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.columnview.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.dnd.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.edit.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);

    $cs->registerCssFile($themePath . '/vendor/plugins/select2/css/core.css');
    $cs->registerScriptFile($themePath . '/vendor/plugins/select2/select2.full.js', CClientScript::POS_END);

    $cs->registerCssFile($themePath . '/vendor/plugins/dropzone/css/dropzone.css');
    $cs->registerScriptFile($themePath . '/vendor/plugins/dropzone/dropzone.min.js', CClientScript::POS_END);
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-menu">
				<div class="chart-legend">
					<table class="table">
						<thead>
						<tr class="primary">
							<td>#ID</td>
							<td>Название товара</td>
							<td>is_closed</td>
							<td>is_trash</td>
							<td>Категория</td>
							<!--
                            <td align="center">Закрыт</td>
                            <td align="center">Опубликован</td>
                            <td align="center">Запрет<br/> индексации</td>
                            -->
							<td style="width: 67px;">&nbsp;</td>
						</tr>
						</thead>
						<tbody>
                        <?php foreach ($oProducts as $oProduct) { ?>
							<tr>
								<td><?= $oProduct->id ?></td>
								<td>
									<a class="Xajax-popup-link"
									   href="<?= $this->createUrl('/cms/product/edit', ['id' => $oProduct->id]) ?>"><?= $oProduct->product_name ?></a>
								</td>
								<td><?= $oProduct->is_closed ? '<i class="fa fa-eye-slash"></i>' : '' ?></td>
								<td><?= $oProduct->is_trash ? '<i class="fa fa-trash-o"></i>' : '' ?></td>
								<td><?= $oProduct->appProduct->tree->node_name ?></td>

                                <?php /*/ ?>
                                <td><?= empty($oQuest->company) ? '-' : $oQuest->company->company_name ?></td>
                                <td><?= $oQuest->ecmProduct->version->version_name ?></td>
                                <td align="center">
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input type="checkbox" <?= $oQuest->ecmProduct->is_closed ? 'checked' : '' ?>
                                               disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td align="center">
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input
                                            type="checkbox" <?= $oQuest->tree->is_node_published ? 'checked' : '' ?>
                                            disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td align="center">
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input
                                            type="checkbox" <?= $oQuest->tree->is_seo_noindexing ? 'checked' : '' ?>
                                            disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <?php //*/ ?>
								<td class="text-right">
									<div class="btn-group text-right">
										<a class="btn btn-success btn-xs fs12" title=""
										   href="<?= $this->createUrl('edit', ['id' => $oProduct->id]) ?>"> <i
													class="fa fa-edit"></i> </a>
										<button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
										        data-toggle="dropdown" aria-expanded="false"><span
													class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdownMenuRight0" role="menu">
											<li>
												<a href="<?= $this->createUrl('edit', ['id' => $oProduct->id]) ?>">Изменить</a>
											</li>
											<li class="divider"></li>
											<li>
												<a class="ajax-popup-link"
												   href="<?= $this->createUrl('delete', ['id' => $oProduct->id]) ?>">Удалить</a>
											</li>
											<li>
												<a href="#">Complete</a>
											</li>
											<li>
												<a href="#">Pending</a>
											</li>
											<li>
												<a href="#">Canceled</a>
											</li>
										</ul>
									</div>
								</td>

							</tr>
                        <?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="application/javascript">
	$(document).ready(function () {
		"use strict";
		// Init Theme Core
		//Core.init();
		// Init Demo JS
		//Demo.init();
	});
</script>
<script type="application/javascript">
	$(document).ready(function () {
		$('.ajax-popup-link').magnificPopup({
			type: 'ajax',
			modal: true
		});
	});
</script>



