    <?php
        if($multi=="free"){
            $boardtitle="자유";
        }else if($multi=="humor"){
            $boardtitle="유머";
        }else if($multi=="qna"){
            $boardtitle="QnA";
        }else if($multi=="photo"){
            $boardtitle="사진";
        }else if($multi=="music"){
            $boardtitle="음악";
        }else{
            $boardtitle="자유";
        }
    ?>
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <span class="fs-4">{{ $boardtitle." ".$toptitle }}</span>
    </div>