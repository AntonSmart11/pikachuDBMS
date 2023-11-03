<?php
    include ("templates/header.php");

    $_SESSION['database'] = '';

    $databases = $db->query("SHOW DATABASES");

    if($databases->num_rows > 0):

        $inf = [];

        while($database = mysqli_fetch_assoc($databases)): 

            $charsets = $db->query("SELECT default_collation_name AS 'charset' FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '".$database['Database']."'");

            $dc = [];

            while($charset = mysqli_fetch_assoc($charsets)):
                
                $dc[] = $database['Database'];
                $dc[] = $charset['charset'];

            endwhile;

            $inf[] = $dc;

        endwhile;
    endif;
?>
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="orders">
                <div class="cardHeader">
                    <h2 class="text-center">Bienvenido a Pikachu DBMS</h2>
                </div>
            </div>
            <div class="orders my-4">
                <div class="cardHeader">
                    <h2 class="text-center">Bases de Datos</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Base de datos</th>
                                        <th>Cotejamiento</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i=0; $i<$databases->num_rows; $i++): ?>
                                    <tr>
                                        <th><?php echo $inf[$i][0]; ?></th>
                                        <th><?php echo $inf[$i][1]; ?></th>
                                        <th>
                                            <?php
                                                if($inf[$i][0] != 'information_schema'):
                                                if($inf[$i][0] != 'mysql'):
                                                if($inf[$i][0] != 'performance_schema'):
                                                if($inf[$i][0] != 'phpmyadmin'):
                                            ?>
                                                <a href="databasesDrop.php?db=<?php echo $inf[$i][0]; ?>">Eliminar</a>
                                            <?php
                                                endif;
                                                endif;
                                                endif;
                                                endif;
                                            ?>
                                        </th>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
                if(isset($_GET['create'])) {
                    if($_GET['create'] == 1) {
                        alert('success', 'Se ha creado correctamente');
                    }
                }
                if(isset($_GET['delete'])) {
                    if($_GET['delete'] == 1) {
                        alert('success', 'Se ha eliminado correctamente');
                    }
                }
                if(isset($_GET['error'])) {
                    if($_GET['error'] == 1) {
                        alert('danger', 'Upss...');
                    }
                }
            ?>
        </div>
        <div class="col-12 col-lg-4">
            <?php
                card('Servidor de base de datos', 
                    'Servidor: '.$db->host_info.
                    '<br>Versión del servidor: '.$db->server_info.
                    '<br>Versión del cliente: '.$db->client_info.
                    '<br>Versión del protocolo: '.$db->protocol_version.
                    '<br>Usuario: '.$_SESSION['user']
                );
            ?>
        </div>
    </div>
<?php
    modal('createDB', 'Crear Base de Datos', 
    formPost('databasesCreate.php', 
        label('text', 'db', 'Nombre de la Base de Datos').
        select('collate', 'Cotejamiento', 
            optionSimpleDisabled('').    
            optionSimpleDisabled('armscii8').
            optionSimple('armscii8_bin','armscii8_bin').
            optionSimple('armscii8_general_ci','armscii8_general_ci').
            optionSimple('armscii8_general_nopad_ci','armscii8_general_nopad_ci').
            optionSimple('armscii8_nopad_bin','armscii8_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('ascii').
            optionSimple('ascii_bin','ascii_bin').
            optionSimple('ascii_general_ci','ascii_general_ci').
            optionSimple('ascii_general_nopad_ci','ascii_general_nopad_ci').
            optionSimple('ascii_nopad_bin','ascii_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('big5').
            optionSimple('big5_bin','big5_bin').
            optionSimple('big5_chinese_ci','big5_chinese_ci').
            optionSimple('big5_chinese_nopad_ci','big5_chinese_nopad_ci').
            optionSimple('big5_nopad_bin','big5_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('binary').
            optionSimple('binary','binary').
            optionSimpleDisabled('').
            optionSimpleDisabled('cp1250').
            optionSimple('cp1250_bin','cp1250_bin').
            optionSimple('cp1250_croatian_ci','cp1250_croatian_ci').
            optionSimple('cp1250_czech_cs','cp1250_czech_cs').
            optionSimple('cp1250_general_ci','cp1250_general_ci').
            optionSimple('cp1250_general_nopad_ci','cp1250_general_nopad_ci').
            optionSimple('cp1250_nopad_bin','cp1250_nopad_bin').
            optionSimple('cp1250_polish_ci','cp1250_polish_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('cp1251').
            optionSimple('cp1251_bin','cp1251_bin').
            optionSimple('cp1251_bulgarian_ci','cp1251_bulgarian_ci').
            optionSimple('cp1251_general_ci','cp1251_general_ci').
            optionSimple('cp1251_general_cs','cp1251_general_cs').
            optionSimple('cp1251_general_nopad_ci','cp1251_general_nopad_ci').
            optionSimple('cp1251_nopad_bin','cp1251_nopad_bin').
            optionSimple('cp1251_ukrainian_ci','cp1251_ukrainian_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('cp1256').
            optionSimple('cp1256_bin','cp1256_bin').
            optionSimple('cp1256_general_ci','cp1256_general_ci').
            optionSimple('cp1256_general_nopad_ci','cp1256_general_nopad_ci').
            optionSimple('cp1256_nopad_bin','cp1256_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('cp1257').
            optionSimple('cp1257_bin','cp1257_bin').
            optionSimple('cp1257_general_ci','cp1257_general_ci').
            optionSimple('cp1257_general_nopad_ci','cp1257_general_nopad_ci').
            optionSimple('cp1257_lithuanian_ci','cp1257_lithuanian_ci').
            optionSimple('cp1257_nopad_bin','cp1257_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('cp850').
            optionSimple('cp850_bin','cp850_bin').
            optionSimple('cp850_general_ci','cp850_general_ci').
            optionSimple('cp850_general_nopad_ci','cp850_general_nopad_ci').
            optionSimple('cp850_nopad_bin','cp850_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('cp852').
            optionSimple('cp852_bin','cp852_bin').
            optionSimple('cp852_general_ci','cp852_general_ci').
            optionSimple('cp852_general_nopad_ci','cp852_general_nopad_ci').
            optionSimple('cp852_nopad_bin','cp852_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('cp866').
            optionSimple('cp866_bin','cp866_bin').
            optionSimple('cp866_general_ci','cp866_general_ci').
            optionSimple('cp866_general_nopad_ci','cp866_general_nopad_ci').
            optionSimple('cp866_nopad_bin','cp866_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('cp932').
            optionSimple('cp932_bin','cp932_bin').
            optionSimple('cp932_japanese_ci','cp932_japanese_ci').
            optionSimple('cp932_japanese_nopad_ci','cp932_japanese_nopad_ci').
            optionSimple('cp932_nopad_bin','cp932_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('dec8').
            optionSimple('dec8_bin','dec8_bin').
            optionSimple('dec8_nopad_bin','dec8_nopad_bin').
            optionSimple('dec8_swedish_ci','dec8_swedish_ci').
            optionSimple('dec8_swedish_nopad_ci','dec8_swedish_nopad_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('eucjpms').
            optionSimple('eucjpms_bin','eucjpms_bin').
            optionSimple('eucjpms_japanese_ci','eucjpms_japanese_ci').
            optionSimple('eucjpms_japanese_nopad_ci','eucjpms_japanese_nopad_ci').
            optionSimple('eucjpms_nopad_bin','eucjpms_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('euckr').
            optionSimple('euckr_bin','euckr_bin').
            optionSimple('euckr_korean_ci','euckr_korean_ci').
            optionSimple('euckr_korean_nopad_ci','euckr_korean_nopad_ci').
            optionSimple('euckr_nopad_bin','euckr_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('gb2312').
            optionSimple('gb2312_bin','gb2312_bin').
            optionSimple('gb2312_chinese_ci','gb2312_chinese_ci').
            optionSimple('gb2312_chinese_nopad_ci','gb2312_chinese_nopad_ci').
            optionSimple('gb2312_nopad_bin','gb2312_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('gbk').
            optionSimple('gbk_bin','gbk_bin').
            optionSimple('gbk_chinese_ci','gbk_chinese_ci').
            optionSimple('gbk_chinese_nopad_ci','gbk_chinese_nopad_ci').
            optionSimple('gbk_nopad_bin','gbk_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('geostd8').
            optionSimple('geostd8_bin','geostd8_bin').
            optionSimple('geostd8_general_ci','geostd8_general_ci').
            optionSimple('geostd8_general_nopad_ci','geostd8_general_nopad_ci').
            optionSimple('geostd8_nopad_bin','geostd8_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('greek').
            optionSimple('greek_bin','greek_bin').
            optionSimple('greek_general_ci','greek_general_ci').
            optionSimple('greek_general_nopad_ci','greek_general_nopad_ci').
            optionSimple('greek_nopad_bin','greek_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('hebrew').
            optionSimple('hebrew_bin','hebrew_bin').
            optionSimple('hebrew_general_ci','hebrew_general_ci').
            optionSimple('hebrew_general_nopad_ci','hebrew_general_nopad_ci').
            optionSimple('hebrew_nopad_bin','hebrew_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('hp8').
            optionSimple('hp8_bin','hp8_bin').
            optionSimple('hp8_english_ci','hp8_english_ci').
            optionSimple('hp8_english_nopad_ci','hp8_english_nopad_ci').
            optionSimple('hp8_nopad_bin','hp8_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('keybcs2').
            optionSimple('keybcs2_bin','keybcs2_bin').
            optionSimple('keybcs2_general_ci','keybcs2_general_ci').
            optionSimple('keybcs2_general_nopad_ci','keybcs2_general_nopad_ci').
            optionSimple('keybcs2_nopad_bin','keybcs2_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('koi8r').
            optionSimple('koi8r_bin','koi8r_bin').
            optionSimple('koi8r_general_ci','koi8r_general_ci').
            optionSimple('koi8r_general_nopad_ci','koi8r_general_nopad_ci').
            optionSimple('koi8r_nopad_bin','koi8r_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('koi8u').
            optionSimple('koi8u_bin','koi8u_bin').
            optionSimple('koi8u_general_ci','koi8u_general_ci').
            optionSimple('koi8u_general_nopad_ci','koi8u_general_nopad_ci').
            optionSimple('koi8u_nopad_bin','koi8u_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('latin1').
            optionSimple('latin1_bin','latin1_bin').
            optionSimple('latin1_danish_ci','latin1_danish_ci').
            optionSimple('latin1_general_ci','latin1_general_ci').
            optionSimple('latin1_general_cs','latin1_general_cs').
            optionSimple('latin1_german1_ci','latin1_german1_ci').
            optionSimple('latin1_german2_ci','latin1_german2_ci').
            optionSimple('latin1_nopad_bin','latin1_nopad_bin').
            optionSimple('latin1_spanish_ci','latin1_spanish_ci').
            optionSimple('latin1_swedish_ci','latin1_swedish_ci').
            optionSimple('latin1_swedish_nopad_ci','latin1_swedish_nopad_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('latin2').
            optionSimple('latin2_bin','latin2_bin').
            optionSimple('latin2_croatian_ci','latin2_croatian_ci').
            optionSimple('latin2_czech_cs','latin2_czech_cs').
            optionSimple('latin2_general_ci','latin2_general_ci').
            optionSimple('latin2_general_nopad_ci','latin2_general_nopad_ci').
            optionSimple('latin2_hungarian_ci','latin2_hungarian_ci').
            optionSimple('latin2_nopad_bin','latin2_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('latin5').
            optionSimple('latin5_bin','latin5_bin').
            optionSimple('latin5_nopad_bin','latin5_nopad_bin').
            optionSimple('latin5_turkish_ci','latin5_turkish_ci').
            optionSimple('latin5_turkish_nopad_ci','latin5_turkish_nopad_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('latin7').
            optionSimple('latin7_bin','latin7_bin').
            optionSimple('latin7_estonian_cs','latin7_estonian_cs').
            optionSimple('latin7_general_ci','latin7_general_ci').
            optionSimple('latin7_general_cs','latin7_general_cs').
            optionSimple('latin7_general_nopad_ci','latin7_general_nopad_ci').
            optionSimple('latin7_nopad_bin','latin7_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('macce').
            optionSimple('macce_bin','macce_bin').
            optionSimple('macce_general_ci','macce_general_ci').
            optionSimple('macce_general_nopad_ci','macce_general_nopad_ci').
            optionSimple('macce_nopad_bin','macce_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('macroman').
            optionSimple('macroman_bin','macroman_bin').
            optionSimple('macroman_general_ci','macroman_general_ci').
            optionSimple('macroman_general_nopad_ci','macroman_general_nopad_ci').
            optionSimple('macroman_nopad_bin','macroman_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('sjis').
            optionSimple('sjis_bin','sjis_bin').
            optionSimple('sjis_japanese_ci','sjis_japanese_ci').
            optionSimple('sjis_japanese_nopad_ci','sjis_japanese_nopad_ci').
            optionSimple('sjis_nopad_bin','sjis_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('swe7').
            optionSimple('swe7_bin','swe7_bin').
            optionSimple('swe7_nopad_bin','swe7_nopad_bin').
            optionSimple('swe7_swedish_ci','swe7_swedish_ci').
            optionSimple('swe7_swedish_nopad_ci','swe7_swedish_nopad_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('tis620').
            optionSimple('tis620_bin','tis620_bin').
            optionSimple('tis620_nopad_bin','tis620_nopad_bin').
            optionSimple('tis620_thai_ci','tis620_thai_ci').
            optionSimple('tis620_thai_nopad_ci','tis620_thai_nopad_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('ucs2').
            optionSimple('ucs2_bin','ucs2_bin').
            optionSimple('ucs2_croatian_ci','ucs2_croatian_ci').
            optionSimple('ucs2_croatian_mysql561_ci','ucs2_croatian_mysql561_ci').
            optionSimple('ucs2_czech_ci','ucs2_czech_ci').
            optionSimple('ucs2_danish_ci','ucs2_danish_ci').
            optionSimple('ucs2_esperanto_ci','ucs2_esperanto_ci').
            optionSimple('ucs2_estonian_ci','ucs2_estonian_ci').
            optionSimple('ucs2_general_ci','ucs2_general_ci').
            optionSimple('ucs2_general_mysql500_ci','ucs2_general_mysql500_ci').
            optionSimple('ucs2_general_nopad_ci','ucs2_general_nopad_ci').
            optionSimple('ucs2_german2_ci','ucs2_german2_ci').
            optionSimple('ucs2_hungarian_ci','ucs2_hungarian_ci').
            optionSimple('ucs2_icelandic_ci','ucs2_icelandic_ci').
            optionSimple('ucs2_latvian_ci','ucs2_latvian_ci').
            optionSimple('ucs2_lithuanian_ci','ucs2_lithuanian_ci').
            optionSimple('ucs2_myanmar_ci','ucs2_myanmar_ci').
            optionSimple('ucs2_nopad_bin','ucs2_nopad_bin').
            optionSimple('ucs2_persian_ci','ucs2_persian_ci').
            optionSimple('ucs2_polish_ci','ucs2_polish_ci').
            optionSimple('ucs2_roman_ci','ucs2_roman_ci').
            optionSimple('ucs2_romanian_ci','ucs2_romanian_ci').
            optionSimple('ucs2_sinhala_ci','ucs2_sinhala_ci').
            optionSimple('ucs2_slovak_ci','ucs2_slovak_ci').
            optionSimple('ucs2_slovenian_ci','ucs2_slovenian_ci').
            optionSimple('ucs2_spanish2_ci','ucs2_spanish2_ci').
            optionSimple('ucs2_spanish_ci','ucs2_spanish_ci').
            optionSimple('ucs2_swedish_ci','ucs2_swedish_ci').
            optionSimple('ucs2_thai_520_w2','ucs2_thai_520_w2').
            optionSimple('ucs2_turkish_ci','ucs2_turkish_ci').
            optionSimple('ucs2_unicode_520_ci','ucs2_unicode_520_ci').
            optionSimple('ucs2_unicode_520_nopad_ci','ucs2_unicode_520_nopad_ci').
            optionSimple('ucs2_unicode_ci','ucs2_unicode_ci').
            optionSimple('ucs2_unicode_nopad_ci','ucs2_unicode_nopad_ci').
            optionSimple('ucs2_vietnamese_ci','ucs2_vietnamese_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('ujis').
            optionSimple('ujis_bin','ujis_bin').
            optionSimple('ujis_japanese_ci','ujis_japanese_ci').
            optionSimple('ujis_japanese_nopad_ci','ujis_japanese_nopad_ci').
            optionSimple('ujis_nopad_bin','ujis_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('utf16').
            optionSimple('utf16_bin','utf16_bin').
            optionSimple('utf16_croatian_ci','utf16_croatian_ci').
            optionSimple('utf16_croatian_mysql561_ci','utf16_croatian_mysql561_ci').
            optionSimple('utf16_czech_ci','utf16_czech_ci').
            optionSimple('utf16_danish_ci','utf16_danish_ci').
            optionSimple('utf16_esperanto_ci','utf16_esperanto_ci').
            optionSimple('utf16_estonian_ci','utf16_estonian_ci').
            optionSimple('utf16_general_ci','utf16_general_ci').
            optionSimple('utf16_general_nopad_ci','utf16_general_nopad_ci').
            optionSimple('utf16_german2_ci','utf16_german2_ci').
            optionSimple('utf16_hungarian_ci','utf16_hungarian_ci').
            optionSimple('utf16_icelandic_ci','utf16_icelandic_ci').
            optionSimple('utf16_latvian_ci','utf16_latvian_ci').
            optionSimple('utf16_lithuanian_ci','utf16_lithuanian_ci').
            optionSimple('utf16_myanmar_ci','utf16_myanmar_ci').
            optionSimple('utf16_nopad_bin','utf16_nopad_bin').
            optionSimple('utf16_persian_ci','utf16_persian_ci').
            optionSimple('utf16_polish_ci','utf16_polish_ci').
            optionSimple('utf16_roman_ci','utf16_roman_ci').
            optionSimple('utf16_romanian_ci','utf16_romanian_ci').
            optionSimple('utf16_sinhala_ci','utf16_sinhala_ci').
            optionSimple('utf16_slovak_ci','utf16_slovak_ci').
            optionSimple('utf16_slovenian_ci','utf16_slovenian_ci').
            optionSimple('utf16_spanish2_ci','utf16_spanish2_ci').
            optionSimple('utf16_spanish_ci','utf16_spanish_ci').
            optionSimple('utf16_swedish_ci','utf16_swedish_ci').
            optionSimple('utf16_thai_520_w2','utf16_thai_520_w2').
            optionSimple('utf16_turkish_ci','utf16_turkish_ci').
            optionSimple('utf16_unicode_520_ci','utf16_unicode_520_ci').
            optionSimple('utf16_unicode_520_nopad_ci','utf16_unicode_520_nopad_ci').
            optionSimple('utf16_unicode_ci','utf16_unicode_ci').
            optionSimple('utf16_unicode_nopad_ci','utf16_unicode_nopad_ci').
            optionSimple('utf16_vietnamese_ci','utf16_vietnamese_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('utf16le').
            optionSimple('utf16le_bin','utf16le_bin').
            optionSimple('utf16le_general_ci','utf16le_general_ci').
            optionSimple('utf16le_general_nopad_ci','utf16le_general_nopad_ci').
            optionSimple('utf16le_nopad_bin','utf16le_nopad_bin').
            optionSimpleDisabled('').
            optionSimpleDisabled('utf32').
            optionSimple('utf32_bin','utf32_bin').
            optionSimple('utf32_croatian_ci','utf32_croatian_ci').
            optionSimple('utf32_croatian_mysql561_ci','utf32_croatian_mysql561_ci').
            optionSimple('utf32_czech_ci','utf32_czech_ci').
            optionSimple('utf32_danish_ci','utf32_danish_ci').
            optionSimple('utf32_esperanto_ci','utf32_esperanto_ci').
            optionSimple('utf32_estonian_ci','utf32_estonian_ci').
            optionSimple('utf32_general_ci','utf32_general_ci').
            optionSimple('utf32_general_nopad_ci','utf32_general_nopad_ci').
            optionSimple('utf32_german2_ci','utf32_german2_ci').
            optionSimple('utf32_hungarian_ci','utf32_hungarian_ci').
            optionSimple('utf32_icelandic_ci','utf32_icelandic_ci').
            optionSimple('utf32_latvian_ci','utf32_latvian_ci').
            optionSimple('utf32_lithuanian_ci','utf32_lithuanian_ci').
            optionSimple('utf32_myanmar_ci','utf32_myanmar_ci').
            optionSimple('utf32_nopad_bin','utf32_nopad_bin').
            optionSimple('utf32_persian_ci','utf32_persian_ci').
            optionSimple('utf32_polish_ci','utf32_polish_ci').
            optionSimple('utf32_roman_ci','utf32_roman_ci').
            optionSimple('utf32_romanian_ci','utf32_romanian_ci').
            optionSimple('utf32_sinhala_ci','utf32_sinhala_ci').
            optionSimple('utf32_slovak_ci','utf32_slovak_ci').
            optionSimple('utf32_slovenian_ci','utf32_slovenian_ci').
            optionSimple('utf32_spanish2_ci','utf32_spanish2_ci').
            optionSimple('utf32_spanish_ci','utf32_spanish_ci').
            optionSimple('utf32_swedish_ci','utf32_swedish_ci').
            optionSimple('utf32_thai_520_w2','utf32_thai_520_w2').
            optionSimple('utf32_turkish_ci','utf32_turkish_ci').
            optionSimple('utf32_unicode_520_ci','utf32_unicode_520_ci').
            optionSimple('utf32_unicode_520_nopad_ci','utf32_unicode_520_nopad_ci').
            optionSimple('utf32_unicode_ci','utf32_unicode_ci').
            optionSimple('utf32_unicode_nopad_ci','utf32_unicode_nopad_ci').
            optionSimple('utf32_vietnamese_ci','utf32_vietnamese_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('utf8').
            optionSimple('utf8_bin','utf8_bin').
            optionSimple('utf8_croatian_ci','utf8_croatian_ci').
            optionSimple('utf8_croatian_mysql561_ci','utf8_croatian_mysql561_ci').
            optionSimple('utf8_czech_ci','utf8_czech_ci').
            optionSimple('utf8_danish_ci','utf8_danish_ci').
            optionSimple('utf8_esperanto_ci','utf8_esperanto_ci').
            optionSimple('utf8_estonian_ci','utf8_estonian_ci').
            optionSimple('utf8_general_ci','utf8_general_ci').
            optionSimple('utf8_general_mysql500_ci','utf8_general_mysql500_ci').
            optionSimple('utf8_general_nopad_ci','utf8_general_nopad_ci').
            optionSimple('utf8_german2_ci','utf8_german2_ci').
            optionSimple('utf8_hungarian_ci','utf8_hungarian_ci').
            optionSimple('utf8_icelandic_ci','utf8_icelandic_ci').
            optionSimple('utf8_latvian_ci','utf8_latvian_ci').
            optionSimple('utf8_lithuanian_ci','utf8_lithuanian_ci').
            optionSimple('utf8_myanmar_ci','utf8_myanmar_ci').
            optionSimple('utf8_nopad_bin','utf8_nopad_bin').
            optionSimple('utf8_persian_ci','utf8_persian_ci').
            optionSimple('utf8_polish_ci','utf8_polish_ci').
            optionSimple('utf8_roman_ci','utf8_roman_ci').
            optionSimple('utf8_romanian_ci','utf8_romanian_ci').
            optionSimple('utf8_sinhala_ci','utf8_sinhala_ci').
            optionSimple('utf8_slovak_ci','utf8_slovak_ci').
            optionSimple('utf8_slovenian_ci','utf8_slovenian_ci').
            optionSimple('utf8_spanish2_ci','utf8_spanish2_ci').
            optionSimple('utf8_spanish_ci','utf8_spanish_ci').
            optionSimple('utf8_swedish_ci','utf8_swedish_ci').
            optionSimple('utf8_thai_520_w2','utf8_thai_520_w2').
            optionSimple('utf8_turkish_ci','utf8_turkish_ci').
            optionSimple('utf8_unicode_520_ci','utf8_unicode_520_ci').
            optionSimple('utf8_unicode_520_nopad_ci','utf8_unicode_520_nopad_ci').
            optionSimple('utf8_unicode_ci','utf8_unicode_ci').
            optionSimple('utf8_unicode_nopad_ci','utf8_unicode_nopad_ci').
            optionSimple('utf8_vietnamese_ci','utf8_vietnamese_ci').
            optionSimpleDisabled('').
            optionSimpleDisabled('utf8mb4').
            optionSimple('utf8mb4_bin','utf8mb4_bin').
            optionSimple('utf8mb4_croatian_ci','utf8mb4_croatian_ci').
            optionSimple('utf8mb4_croatian_mysql561_ci','utf8mb4_croatian_mysql561_ci').
            optionSimple('utf8mb4_czech_ci','utf8mb4_czech_ci').
            optionSimple('utf8mb4_danish_ci','utf8mb4_danish_ci').
            optionSimple('utf8mb4_esperanto_ci','utf8mb4_esperanto_ci').
            optionSimple('utf8mb4_estonian_ci','utf8mb4_estonian_ci').
            optionSimpleSelected('utf8mb4_general_ci','utf8mb4_general_ci', true).
            optionSimple('utf8mb4_general_nopad_ci','utf8mb4_general_nopad_ci').
            optionSimple('utf8mb4_german2_ci','utf8mb4_german2_ci').
            optionSimple('utf8mb4_hungarian_ci','utf8mb4_hungarian_ci').
            optionSimple('utf8mb4_icelandic_ci','utf8mb4_icelandic_ci').
            optionSimple('utf8mb4_latvian_ci','utf8mb4_latvian_ci').
            optionSimple('utf8mb4_lithuanian_ci','utf8mb4_lithuanian_ci').
            optionSimple('utf8mb4_myanmar_ci','utf8mb4_myanmar_ci').
            optionSimple('utf8mb4_nopad_bin','utf8mb4_nopad_bin').
            optionSimple('utf8mb4_persian_ci','utf8mb4_persian_ci').
            optionSimple('utf8mb4_polish_ci','utf8mb4_polish_ci').
            optionSimple('utf8mb4_roman_ci','utf8mb4_roman_ci').
            optionSimple('utf8mb4_romanian_ci','utf8mb4_romanian_ci').
            optionSimple('utf8mb4_sinhala_ci','utf8mb4_sinhala_ci').
            optionSimple('utf8mb4_slovak_ci','utf8mb4_slovak_ci').
            optionSimple('utf8mb4_slovenian_ci','utf8mb4_slovenian_ci').
            optionSimple('utf8mb4_spanish2_ci','utf8mb4_spanish2_ci').
            optionSimple('utf8mb4_spanish_ci','utf8mb4_spanish_ci').
            optionSimple('utf8mb4_swedish_ci','utf8mb4_swedish_ci').
            optionSimple('utf8mb4_thai_520_w2','utf8mb4_thai_520_w2').
            optionSimple('utf8mb4_turkish_ci','utf8mb4_turkish_ci').
            optionSimple('utf8mb4_unicode_520_ci','utf8mb4_unicode_520_ci').
            optionSimple('utf8mb4_unicode_520_nopad_ci','utf8mb4_unicode_520_nopad_ci').
            optionSimple('utf8mb4_unicode_ci','utf8mb4_unicode_ci').
            optionSimple('utf8mb4_unicode_nopad_ci','utf8mb4_unicode_nopad_ci').
            optionSimple('utf8mb4_vietnamese_ci','utf8mb4_vietnamese_ci')
        ).
        '<div class="d-flex justify-content-end">'.
            submit('Confirmar').
        '</div>'
        )
    );

    'CREATE DATABASE prueba2
    COLLATE utf8mb4_spanish_ci;';

    include ("templates/footer.php");
?>