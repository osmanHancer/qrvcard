<?php

require_once __DIR__ . "/_login.php";
require_once __DIR__ . "/../helper/dbC.php";
require_once __DIR__ . "/../helper/helper.php";

$userList = dbC::getDB()->all("
Select * FROM users WHERE 1;");

$headers = array_keys($USER_FIELDS);
$headers = array_diff($headers, ['img', "passw", 'logo']);  //remove from table

// $editFields = array_map(function ($el) {
//     $type = "text";
//     if (in_array($el, ["logo", "img", "file"])) $type = "file";
//     if (in_array($el, ["note_end", "date"])) $type = "date";
//     if (in_array($el, ["state"])) $type = "number";
//     return [$el => $type];
// }, $headers);

function fixText($myStr)
{
    $len = strlen($myStr);
    $str = substr($myStr, 0, 40);
    return $str . ($len > strlen($str) ? "..." : "");
}
function createLink($item)
{
    return HOST_URL . '/?' . $item["id"] . '_' . $item["rand"];
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>QR VCard Admin</title>
    <link type="text/css" rel="stylesheet" href="./admin.css">
</head>

<body>
    <script>
        const userList = <?php echo json_encode($userList??null) ?>;
        const PORTAL_URL = '<?php echo $PORTAL_URL?>';
        var _MODE = 'admin';

        function edit(index) {
            const _activeEditItem = index > -1 ? userList[index] : null;
            formFill(_activeEditItem);
        }

        function onSearchKeyUp() {
            let input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.querySelector("#vcardList tbody");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                tdlist = tr[i].getElementsByTagName("td");
                let showrow = false;
                if (!tdlist.length > 0) continue;
                for (let j = 0; j < tdlist.length; j++) {
                    const td = tdlist[j];
                    if (!td) continue;
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        showrow = true;
                        break;
                    }

                }
                tr[i].style.display = showrow ? "" : "none";
            }
        }

        function copyClip(event, key) {
            console.log(event,userList[key]);
            let user= userList[key]??null;
            if(!user) return alert('err');
            let url= `${PORTAL_URL}?${user.id}_${user.rand}`;
            let text = `Vcard Profil Link: ${url}
Vcard Düzenleme Link: ${url}=${user.passw}
Düzenleme linki ile profil düzenlenebilir.`;
            navigator.clipboard.writeText(text).then(() => {
                 event.target.innerText="Kopyalandı";
                 event.target.style.backgroundColor="#5F5";

                },() => {
                    alert('err')
                }
            );
        }
    </script>
    <h1>Kullanıcı Listesi</h1>

    <?php require_once __DIR__ . "/_form.phtml"; ?>
    <div class="form-row">
        <div class="input-field" style="width: 620px;">
            <input type="text" id="search" placeholder=" " onkeyup="onSearchKeyUp()" />
            <label for="search">Arama</label>
            <div class="bar"></div>
        </div>
    </div>
    <table id="vcardList" class="styled-table">
        <thead>
            <tr>
                <?php foreach ($headers as $key) : ?>
                    <th style="max-width: 250px;  word-wrap: break-word;"> <?php echo $key; ?></th>
                <?php endforeach; ?>
                <td>
                    <button onclick="edit(`-1`)">Ekle</button>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userList as $key => $value) : ?>
                <tr id="row_<?= $key ?>">
                    <?php foreach ($headers as $h) : ?>
                        <td style="max-width: 250px;  word-wrap: break-word;">
                            <?php if ($h == 'name') { ?>
                                <a href="<?= createLink($value) ?>" target="_blank"><?= fixText($value[$h]) ?></a>
                            <?php } else echo fixText($value[$h]) ?>
                        </td>
                    <?php endforeach; ?>
                    <td>
                        <button onclick="edit('<?= $key ?>')">Edit</button>
                        <button onclick="copyClip(event,'<?= $key ?>')">Copy Info</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</body>

</html>