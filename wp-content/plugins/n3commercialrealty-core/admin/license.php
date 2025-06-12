<?php 
// require __DIR__ . '/../vendor/autoload.php';
use Keygen\Keygen;

if(isset($_POST['submit'])) {

    $yourkey = strtoupper(Keygen::bytes(5)->hex()->prefix('N3COMMERCIALREALTY-')->generate(true).'-'. Keygen::bytes(5)->hex()->generate().'-'. Keygen::bytes(5)->hex()->generate().'-'. Keygen::bytes(5)->hex()->generate().'-'. Keygen::bytes(5)->hex()->generate());
    $password = trim($yourkey.$_POST['name'].$_POST['email'].date('m/d/Y', strtotime($_POST['date'])));
    $yourHashkey = password_hash($password, PASSWORD_DEFAULT);
}

?>

<form action="" class="shadow p-5 mb-5 bg-body rounded border mt-xxl-5 mx-xxl-5" method="POST">
    <?php if(isset($errorNoti)) {?>
        <div class="alert alert-danger">
            <?=$errorNoti?>
        </div>
    <?php } ?>
    <?php if(!isset($_POST['submit'])) {?>
    <div class="mb-3">
        <label for="name" class="form-label text-primary">Your Domain</label>
        <input type="text" value="<?=isset($_POST['name'])?$_POST['name']:null;?>" class="form-control" id="name" name="name" placeholder="e.g: abc.com" required>
        <div id="emailHelp" class="form-text">Don't add <code>http://</code></div>

    </div>
    <div class="mb-3">
        <label for="email" class="form-label text-primary">Your Email</label>
        <input type="email" value="<?=isset($_POST['email'])?$_POST['email']:null;?>" class="form-control" id="email" name="email" placeholder="e.g: demo@at.com" required>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label text-primary">Your Package</label>
        <input type="date" value="<?=isset($_POST['date'])?$_POST['date']:null;?>" class="form-control" id="date" name="date" required>
        <div id="emailHelp" class="form-text">Format: <code>MM/DD/YYYY</code></div>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    <?php } else { ?>
    <div class="mb-0">
        <div class="fs-3 text-primary">Your License</div>
        <div id="youkey" class="border rounded border-3 p-4 mt-3 mb-4 fs-5 bg-light text-break">
            <p class="fw-bold mb-0">You Domain:</p>
            <p><?=isset($_POST['name'])?$_POST['name']:null;?></p>
            <p class="fw-bold mb-0">You Email:</p>
            <p><?=isset($_POST['email'])?$_POST['email']:null;?></p>
            <p class="fw-bold mb-0">You Package:</p>
            <p><?=isset($_POST['date'])?date('m/d/Y', strtotime($_POST['date'])):null;?></p>
            <p class="fw-bold mb-0">You Key:</p>
            <p><?=isset($yourkey)?$yourkey:null;?></p>
            <p class="fw-bold mb-0">You License:</p>
            <p class="mb-0"><?=isset($yourHashkey)?$yourHashkey:null;?></p>
        </div>
    </div>
    <?php } ?>

</form>