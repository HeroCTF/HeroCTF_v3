<?php
require_once("Model/UserDAO.php");
require_once("Model/User.php");
require_once("Controller.php");
class RegisterController implements Controller
{
    /**
     * @param Request the request from clients
     * This method is used to verify if a user is already logged in. If not, try to register him with the provided informations.
     */
    public function handle($request)
    {
        if (isset($_SESSION['email'])) header('Location:?page=myBooks');
        else $this->register();
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["pseudo"]) && isset($_POST["email"]) && isset($_POST['password'])){
            $_SESSION['retEmail'] = "";
            $_SESSION['retPseudo'] = "";
            $_SESSION['msgE'] = "";
            $_SESSION['msg'] = "";
            if(!empty($_POST["pseudo"]) && !empty($_POST["email"]) && !empty($_POST['password'])){
                $res = UserDAO::getInstance()->findAll();
                $password = htmlspecialchars($_POST['password']);
                $email = htmlspecialchars($_POST['email']);
                $pseudo = htmlspecialchars($_POST["pseudo"]);
                $isUnique = True;
                foreach($res as $r){
                    if($email === $r->getEmail()){
                        $isUnique = False;
                        break;
                    }
                }
                if($isUnique){
                    if(strlen($pseudo) < 20){
                        if(strlen($email)< 75){
                            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                                $blacklist = ['0-mail.com', '0815.ru', '0815.ru0clickemail.com', '0clickemail.com', '0wnd.net', '0wnd.org', '10minutemail.com', '10minutemail.de', '123-m.com', '126.com', '12minutemail.com', '139.com', '163.com', '1ce.us', '1chuan.com', '1pad.de', '1zhuan.com', '20minutemail.com', '21cn.com', '24hourmail.com', '2prong.com', '30minutemail.com', '33mail.com', '3d-painting.com', '4warding.com', '4warding.net', '4warding.org', '60minutemail.com', '675hosting.com', '675hosting.net', '675hosting.org', '6ip.us', '6paq.com', '6url.com', '75hosting.com', '75hosting.net', '75hosting.org', '7days-printing.com', '7tags.com', '99experts.com', '9ox.net', 'a-bc.net', 'afrobacon.com', 'ag.us.to', 'agedmail.com', 'ajaxapp.net', 'akapost.com', 'ama-trade.de', 'ama-trans.de', 'amilegit.com', 'amiri.net', 'amiriindustries.com', 'ano-mail.net', 'anonbox.net', 'anonymail.dk', 'anonymbox.com', 'anonymousmail.org', 'anonymousspeech.com', 'antichef.com', 'antichef.net', 'antireg.com', 'antispam.de', 'armyspy.com', 'azmeil.tk', 'baxomale.ht.cx', 'beefmilk.com', 'big1.us', 'bigstring.com', 'binkmail.com', 'bio-muesli.net', 'bloatbox.com', 'blogmyway.org', 'blogos.com', 'bluebottle.com', 'bobmail.info', 'bodhi.lawlita.com', 'bofthew.com', 'boxformail.in', 'brainonfire.net', 'brefmail.com', 'brennendesreich.de', 'broadbandninja.com', 'bsnow.net', 'bspamfree.org', 'buffemail.com', 'bugmenot.com', 'bumpymail.com', 'bund.us', 'buyusedlibrarybooks.org', 'c2.hu', 'casualdx.com', 'cellurl.com', 'centermail.com', 'centermail.net', 'chammy.info', 'cheatmail.de', 'chogmail.com', 'choicemail1.com', 'chong-mail.com', 'chong-mail.net', 'chong-mail.org', 'clixser.com', 'cmail.com', 'cmail.net', 'cmail.org', 'consumerriot.com', 'cool.fr.nf', 'correo.blogos.net', 'cosmorph.com', 'courriel.fr.nf', 'courrieltemporaire.com', 'crapmail.org', 'cubiclink.com', 'curryworld.de', 'cust.in', 'cuvox.de', 'dacoolest.com', 'dandikmail.com', 'dayrep.com', 'dbunker.com', 'dcemail.com', 'deadaddress.com', 'deadchildren.org', 'deadspam.com', 'deagot.com', 'dealja.com', 'despam.it', 'despammed.com', 'devnullmail.com', 'dfgh.net', 'dharmatel.net', 'digitalsanctuary.com', 'dingbone.com', 'discardmail.com', 'discardmail.de', 'disposableaddress.com', 'disposableinbox.com', 'dispose.it', 'disposeamail.com', 'disposemail.com', 'dispostable.com', 'dm.w3internet.co.uk', 'dm.w3internet.co.uk example.com', 'dm.w3internet.co.ukexample.com', 'docmail.com', 'dodgeit.com', 'dodgit.com', 'dodgit.org', 'domozmail.com', 'donemail.ru', 'dontreg.com', 'dontsendmespam.de', 'dotmsg.com', 'drdrb.com', 'drdrb.net', 'dropcake.de', 'droplister.com', 'dudmail.com', 'dump-email.info', 'dumpandjunk.com', 'dumpmail.de', 'dumpyemail.com', 'duskmail.com', 'e-mail.com', 'e-mail.org', 'e-postkasten.com', 'e-postkasten.de', 'e-postkasten.eu', 'e-postkasten.info', 'e4ward.com', 'easytrashmail.com', 'einrot.com', 'einrot.de', 'email60.com', 'emaildienst.de', 'emailgo.de', 'emailias.com', 'emailigo.de', 'emailinfive.com', 'emaillime.com', 'emailmiser.com', 'emailsensei.com', 'emailtemporar.ro', 'emailtemporario.com.br', 'emailthe.net', 'emailtmp.com', 'emailto.de', 'emailwarden.com', 'emailx.at.hm', 'emailxfer.com', 'emeil.in', 'emeil.ir', 'emz.net', 'enterto.com', 'ephemail.net', 'etranquil.com', 'etranquil.net', 'etranquil.org', 'example.com', 'explodemail.com', 'eyepaste.com', 'faecesmail.me', 'fakedemail.com', 'fakeinbox.com', 'fakeinformation.com', 'fakemail.fr', 'fakemailgenerator.com', 'fakemailz.com', 'fantasymail.de', 'fastacura.com', 'fastchevy.com', 'fastchrysler.com', 'fastermail.com', 'fastkawasaki.com', 'fastmazda.com', 'fastmitsubishi.com', 'fastnissan.com', 'fastsubaru.com', 'fastsuzuki.com', 'fasttoyota.com', 'fastyamaha.com', 'fatflap.com', 'fdfdsfds.com', 'fightallspam.com', 'filzmail.com', 'fizmail.com', 'fleckens.hu', 'fly-ts.de', 'flyspam.com', 'footard.com', 'forgetmail.com', 'fornow.eu', 'fr33mail.info', 'frapmail.com', 'freecoolemail.com', 'freemail.ms', 'friendlymail.co.uk', 'front14.org', 'fudgerub.com', 'fux0ringduh.com', 'garliclife.com', 'gawab.com', 'get1mail.com', 'get2mail.fr', 'getairmail.com', 'getmails.eu', 'getonemail.com', 'getonemail.net', 'ghosttexter.de', 'girlsundertheinfluence.com', 'gishpuppy.com', 'gmx.com', 'goemailgo.com', 'gorillaswithdirtyarmpits.com', 'gotmail.com', 'gotmail.net', 'gotmail.org', 'gotti.otherinbox.com', 'gowikibooks.com', 'gowikicampus.com', 'gowikicars.com', 'gowikifilms.com', 'gowikigames.com', 'gowikimusic.com', 'gowikinetwork.com', 'gowikitravel.com', 'gowikitv.com', 'great-host.in', 'greensloth.com', 'gsrv.co.uk', 'guerillamail.biz', 'guerillamail.com', 'guerillamail.net', 'guerillamail.org', 'guerrillamail.biz', 'guerrillamail.com', 'guerrillamail.de', 'guerrillamail.net', 'guerrillamail.org', 'guerrillamailblock.com', 'gustr.com', 'h.mintemail.com', 'h8s.org', 'hacccc.com', 'haltospam.com', 'hatespam.org', 'herp.in', 'hidemail.de', 'hidzz.com', 'hmamail.com', 'hochsitze.com', 'hooohush.ai', 'hotpop.com', 'huajiachem.cn', 'hulapla.de', 'hushmail.com', 'i2pmail.org', 'ieatspam.eu', 'ieatspam.info', 'ihateyoualot.info', 'iheartspam.org', 'imails.info', 'imstations.com', 'inbax.tk', 'inboxalias.com', 'inboxclean.com', 'inboxclean.org', 'incognitomail.com', 'incognitomail.net', 'incognitomail.org', 'insorg-mail.info', 'instant-mail.de', 'instantemailaddress.com', 'ipoo.org', 'irish2me.com', 'iroid.com', 'iwantmyname.com', 'iwi.net', 'jetable.com', 'jetable.fr.nf', 'jetable.net', 'jetable.org', 'jnxjn.com', 'jourrapide.com', 'jsrsolutions.com', 'junk1e.com', 'k2-herbal-incenses.com', 'kasmail.com', 'kaspop.com', 'keepmymail.com', 'killmail.com', 'killmail.net', 'kir.ch.tc', 'klassmaster.com', 'klassmaster.net', 'klzlk.com', 'koszmail.pl', 'kulturbetrieb.info', 'kurzepost.de', 'lags.us', 'lavabit.com', 'lawlita.com', 'letthemeatspam.com', 'lhsdv.com', 'lifebyfood.com', 'link2mail.net', 'litedrop.com', 'lol.com', 'lol.ovpn.to', 'lookugly.com', 'lopl.co.cc', 'lortemail.dk', 'lovebitco.in', 'lovemeleaveme.com', 'lr7.us', 'lr78.com', 'lroid.com', 'luv2.us', 'm4ilweb.info', 'maboard.com', 'mail-filter.com', 'mail-temporaire.fr', 'mail.by', 'mail.me', 'mail.mezimages.net', 'mail114.net', 'mail2rss.org', 'mail333.com', 'mail4trash.com', 'mailbidon.com', 'mailblocks.com', 'mailbucket.org', 'mailcatch.com', 'maildrop.cc', 'maileater.com', 'mailexpire.com', 'mailfa.tk', 'mailforspam.com', 'mailfreeonline.com', 'mailguard.me', 'mailin8r.com', 'mailinater.com', 'mailinator.com', 'mailinator.net', 'mailinator.org', 'mailinator.us', 'mailinator2.com', 'mailincubator.com', 'mailme.ir', 'mailme.lv', 'mailme24.com', 'mailmetrash.com', 'mailmoat.com', 'mailnator.com', 'mailnesia.com', 'mailnull.com', 'mailquack.com', 'mailscrap.com', 'mailshell.com', 'mailsiphon.com', 'mailslapping.com', 'mailslite.com', 'mailwithyou.com', 'mailzilla.com', 'mailzilla.org', 'makemetheking.com', 'malahov.de', 'manybrain.com', 'mbx.cc', 'mega.zik.dj', 'meinspamschutz.de', 'meltmail.com', 'messagebeamer.de', 'mezimages.net', 'mierdamail.com', 'migumail.com', 'mintemail.com', 'mmmmail.com', 'mobi.web.id', 'mobileninja.co.uk', 'moburl.com', 'moncourrier.fr.nf', 'monemail.fr.nf', 'monmail.fr.nf', 'ms9.mailslite.com', 'msa.minsmail.com', 'msg.mailslite.com', 'mt2009.com', 'mt2014.com', 'mx0.wwwnew.eu', 'mycleaninbox.net', 'myemailboxy.com', 'mymail-in.net', 'mypacks.net', 'mypartyclip.de', 'myphantomemail.com', 'myspaceinc.com', 'myspaceinc.net', 'myspaceinc.org', 'myspacepimpedup.com', 'myspamless.com', 'mytempemail.com', 'mythrashmail.net', 'mytrashmail.com', 'neomailbox.com', 'nepwk.com', 'nervmich.net', 'nervtmich.net', 'netmails.com', 'netmails.net', 'netzidiot.de', 'neverbox.com', 'nice-4u.com', 'no-spam.ws', 'nobulk.com', 'noclickemail.com', 'nogmailspam.info', 'nomail.xl.cx', 'nomail2me.com', 'nomorespamemails.com', 'nospam.wins.com.br', 'nospam.ze.tc', 'nospam4.us', 'nospamfor.us', 'nospamthanks.info', 'notmailinator.com', 'notsharingmy.info', 'nowhere.org', 'nowmymail.com', 'nurfuerspam.de', 'nus.edu.sg', 'nwldx.com', 'o2.co.uk', 'o2.pl', 'objectmail.com', 'obobbo.com', 'oneoffemail.com', 'oneoffmail.com', 'onewaymail.com', 'online.ms', 'oopi.org', 'opayq.com', 'ordinaryamerican.net', 'otherinbox.com', 'ourklips.com', 'outlawspam.com', 'ovpn.to', 'owlpic.com', 'pancakemail.com', 'pcusers.otherinbox.com', 'pepbot.com', 'phentermine-mortgages-texas-holdem.biz', 'pimpedupmyspace.com', 'pjjkp.com', 'poczta.onet.pl', 'politikerclub.de', 'poofy.org', 'pookmail.com', 'privacy.net', 'privy-mail.com', 'proxymail.eu', 'prtnx.com', 'punkass.com', 'putthisinyourspamdatabase.com', 'qq.com', 'quickinbox.com', 'rcpt.at', 'recode.me', 'recursor.net', 'recyclemail.dk', 'regbypass.com', 'regbypass.comsafe-mail.net', 'rejectmail.com', 'rhyta.com', 'rklips.com', 'rmqkr.net', 'rocketmail.com', 'royal.net', 'rppkn.com', 'rtrtr.com', 's0ny.net', 'safe-mail.net', 'safersignup.de', 'safetymail.info', 'safetypost.de', 'sandelf.de', 'saynotospams.com', 'scatmail.com', 'schafmail.de', 'secure-mail.biz', 'selfdestructingmail.com', 'sendspamhere.com', 'sharklasers.com', 'shiftmail.com', 'shortmail.net', 'sibmail.com', 'sina.cn', 'sina.com', 'sinnlos-mail.de', 'siteposter.net', 'skeefmail.com', 'sky-ts.de', 'slaskpost.se', 'slave-auctions.net', 'slopsbox.com', 'smellfear.com', 'snakemail.com', 'sneakemail.com', 'snkmail.com', 'sofimail.com', 'sofort-mail.de', 'sogetthis.com', 'soodomail.com', 'soodonims.com', 'spam-be-gone.com', 'spam.la', 'spam.su', 'spam4.me', 'spamarrest.com', 'spamavert.com', 'spambob.com', 'spambob.net', 'spambob.org', 'spambog.com', 'spambog.de', 'spambog.ru', 'spambox.info', 'spambox.irishspringrealty.com', 'spambox.us', 'spamcannon.com', 'spamcannon.net', 'spamcero.com', 'spamcon.org', 'spamcorptastic.com', 'spamcowboy.com', 'spamcowboy.net', 'spamcowboy.org', 'spamday.com', 'spamdecoy.net', 'spamex.com', 'spamfree.eu', 'spamfree24.com', 'spamfree24.de', 'spamfree24.eu', 'spamfree24.info', 'spamfree24.net', 'spamfree24.org', 'spamgourmet.com', 'spamgourmet.net', 'spamgourmet.org', 'spamherelots.com', 'SpamHerePlease.com', 'spamhole.com', 'spamify.com', 'spaminator.de', 'spamkill.info', 'spaml.com', 'spaml.de', 'spammotel.com', 'spamobox.com', 'spamoff.de', 'spamsalad.in', 'spamslicer.com', 'spamspot.com', 'spamthis.co.uk', 'spamthisplease.com', 'spamtrail.com', 'spamtroll.net', 'speed.1s.fr', 'spoofmail.de', 'squizzy.de', 'stinkefinger.net', 'stuffmail.de', 'supergreatmail.com', 'supermailer.jp', 'superrito.com', 'superstachel.de', 'suremail.info', 'tagyourself.com', 'talkinator.com', 'tapchicuoihoi.com', 'teewars.org', 'teleworm.com', 'teleworm.us', 'temp.emeraldwebmail.com', 'tempail.com', 'tempalias.com', 'tempe-mail.com', 'tempemail.biz', 'tempemail.co.za', 'tempemail.com', 'tempemail.net', 'tempimbox.com', 'tempinbox.co.uk', 'tempinbox.com', 'tempmail.it', 'tempmail2.com', 'tempmaildemo.com', 'tempomail.fr', 'temporarily.de', 'temporarioemail.com.br', 'temporaryemail.net', 'temporaryemail.us', 'temporaryforwarding.com', 'temporaryinbox.com', 'tempthe.net', 'thanksnospam.info', 'thankyou2010.com', 'thisisnotmyrealemail.com', 'throwawayemailaddress.com', 'throwawaymail.com', 'tilien.com', 'tittbit.in', 'tmailinator.com', 'topcoolemail.com', 'topfreeemail.com', 'tormail.net', 'tormail.org', 'tradermail.info', 'trash-amil.com', 'trash-mail.at', 'trash-mail.com', 'trash-mail.de', 'trash2009.com', 'trash2010.com', 'trash2011.com', 'trashdevil.com', 'trashdevil.de', 'trashemail.de', 'trashmail.at', 'trashmail.com', 'trashmail.de', 'trashmail.me', 'trashmail.net', 'trashmail.org', 'trashmail.ws', 'trashmailer.com', 'trashymail.com', 'trashymail.net', 'trayna.com', 'trillianpro.com', 'turual.com', 'twinmail.de', 'tyldd.com', 'uggsrock.com', 'umail.net', 'upliftnow.com', 'uplipht.com', 'uroid.com', 'venompen.com', 'verticalscope.com', 'veryrealemail.com', 'veryrealmail.com', 'vidchart.com', 'viditag.com', 'viewcastmedia.com', 'viewcastmedia.net', 'viewcastmedia.org', 'vistomail.com', 'vubby.com', 'walala.org', 'webemail.me', 'webm4il.info', 'weg-werf-email.de', 'wegwerf-email-addressen.de', 'wegwerf-emails.de', 'wegwerfadresse.de', 'wegwerfemail.de', 'wegwerfmail.de', 'wegwerfmail.info', 'wegwerfmail.net', 'wegwerfmail.org', 'wetrainbayarea.com', 'wetrainbayarea.org', 'wh4f.org', 'whatiaas.com', 'whatpaas.com', 'whatsaas.com', 'whopy.com', 'whyspam.me', 'wilemail.com', 'willhackforfood.biz', 'willselfdestruct.com', 'winemaven.info', 'wronghead.com', 'wuzup.net', 'wuzupmail.net', 'wwwnew.eu', 'xagloo.com', 'xemaps.com', 'xents.com', 'xmaily.com', 'xoxox.cc', 'xoxy.net', 'xxtreamcam.com', 'xyzfree.net', 'yandex.com', 'yeah.net', 'yep.it', 'yogamaven.com', 'yopmail.com', 'yopmail.fr', 'yopmail.net', 'yourdomain.com', 'ypmail.webarnak.fr.eu.org', 'yuurok.com', 'z1p.biz', 'za.com', 'zehnminutenmail.de', 'zippymail.info', 'zoaxe.com', 'zoemail.net', 'zoemail.org', 'zomg.info'];
                                $found = False;
                                foreach($blacklist as $b){
                                    if(strpos(strtolower($email),$b) !== False){
                                        $found = True;
                                        break;
                                    }
                                }
                                if($found === False){
                                    $uppercase = 1;//preg_match('@[A-Z]@', $password);
                                    $lowercase = 1;//preg_match('@[a-z]@', $password);
                                    $number = 1;//preg_match('@[0-9]@', $password);

                                    if ($uppercase == 1 && $lowercase == 1 && $number == 1) {
                                        $user = new User();
                                        $user->init($pseudo,$email,$password);
                                        UserDAO::getInstance()->insert($user);
                                        $_SESSION['msg'] = "Your account as been created. You can <a href='?page=/'>login</a>.";
                                    }else{
                                        $_SESSION['retEmail'] = $email;
                                        $_SESSION['retPseudo'] = $pseudo;
                                        $_SESSION['msgE'] = "Password must be at least 8 characters and contains one uppercase, one lowercase, and one number.";
                                    }
                                }else{
                                    $_SESSION['retEmail'] = $email;
                                    $_SESSION['retPseudo'] = $pseudo;
                                    $_SESSION['msgE'] = "You can't use a temp mail, sorry.";
                                }
                            }else{
                                $_SESSION['retEmail'] = $email;
                                $_SESSION['retPseudo'] = $pseudo;
                                $_SESSION['msgE'] = "Unvalid mail address.";
                            }
                        }else{
                            $_SESSION['retEmail'] = $email;
                            $_SESSION['retPseudo'] = $pseudo;
                            $_SESSION['msgE'] = "Mail address must be at least 75 characters.";
                        }
                    }else{
                        $_SESSION['retEmail'] = $email;
                        $_SESSION['retPseudo'] = $pseudo;
                        $_SESSION['msgE'] = "Pseudo must be at least 20 characters.";
                    }
                }else{
                    $_SESSION['retEmail'] = $email;
                    $_SESSION['retPseudo'] = $pseudo;
                    $_SESSION['msgE'] = "Mail address already in use, please, choose another one.";
                }
            }else{
                $_SESSION['msgE'] = "A field can't be empty.";
            }
        }else{
            $_SESSION['msgE'] = 'A field is missing.';
        }
        header("Location:?page=/");
    }
}
?>