<?php 
if(opcache_reset()){
    echo "Opcache vidé avec succès";
}else{
    echo "Erreur vidage cache opcache";
}
