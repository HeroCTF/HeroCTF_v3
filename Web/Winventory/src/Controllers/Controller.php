<?php
interface Controller{
    /**
     * @param $request Le paramètre passé dans ?page
     */
    public function handle($request);
    
}
?>
