<?php
if (isset($_POST['submit'])) {
    # code...
    $errors = [];
    if(!isset($_POST['full_name']) || isset($_POST['full_name']) && empty($_POST['full_name']) ){
        $errors['full_name'] = 'ce champs est requis';
    }elseif (isset($_POST['full_name'])) {
        if (strlen($_POST['full_name']) < 3) {
            # code...
            $errors['full_name'] = 'le nom est trop court';
        }else {
            $name = $_POST['full_name'];
        }
    }
    if(!isset($_POST['email']) || isset($_POST['email']) && empty($_POST['email']) ){
        $errors['email'] = 'ce champs est requis';
    }elseif (isset($_POST['email'])) {
        $pattern = "^[_a-z0-9]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
    
        if (!preg_match($pattern, $_POST['email'])) {
            $errors['email'] = 'le mail est incorect';
        }else {
            $email = $_POST['email'];
        }
        
    }
    if(!isset($_POST['object']) || isset($_POST['object']) && empty($_POST['object']) ){
        $errors['object'] = 'ce champs est requis';
    }elseif (isset($_POST['object'])) {
        if (strlen($_POST['object']) < 15) {
            # code...
            $errors['object'] = 'l\'objet est trop court';
        }else {
            $object = $_POST['object'];
        }
    }
    if(!isset($_POST['message']) || isset($_POST['message']) && empty($_POST['message']) ){
        $errors['message'] = 'ce champs est requis';
    }elseif (isset($_POST['message'])) {
        if (str_word_count($_POST['message']) < 10) {
            # code...
            $errors['message'] = 'le message est tres court';
        }else{
            $msg = $_POST['message'];
        }
    }
    if (count($errors) > 0) {
        
    } else {
        # code...
        $success = 'le champs a ete rempli';
        $headers = 'MIME-Version: 1.0' . '\r\n';
        $headers .= 'From: '. $email . '<' . $email . '>' . '\r\n' . 'reply-to:' . $email . '\r\n' . 'X-Mailer: PHP/' . phpversion();
            require_once './phpmailer/class.phpmailer.php';
            require_once './phpmailer/class.smtp.php';
            #require_once './phpmailer/PHPMailerAutoload.php';
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '6fcca140e39649';
        $phpmailer->Password = '4b3d9472fd2bf2';
        $phpmailer->From = $email;
        $phpmailer->FromName = $name;
        $phpmailer->Subject = $object;
        $phpmailer->AltBody = $msg;
        $phpmailer->MsgHTML($msg);
        $phpmailer->AddAddress('rodriguenzouda35@gmail.com', 'Rodrigue NZOUDA');
        if ($phpmailer->send()) {
        # code...
        require_once './database.php';
        $SQL = 'INSERT INTO contacts set full_name=?, email=?, objet=?, mail_msg=?';
        $PARAMS = array(
            $name, $email, $object, $msg
        );
        request($SQL, $PARAMS);
        $phpmailer->FromName = 'Rodrigue NZOUDA';
        $phpmailer->Subject = 'Confirmation de reception d\'email';
        $phpmailer->AltBody = 'Merci d\'avoir rempli ce formulaire de contact. je vous recontacte dans un bref delai';
        $phpmailer->MsgHTML('Merci d\'avoir rempli ce formulaire de contact. je vous recontacte dans un bref delai');
        $phpmailer->AddAddress($email, $name);
        $phpmailer->send();

       } else {
        # code...
        echo $phpmailer->ErrorInfo;
       }
    }
} else {
    # code...
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./LOGX-10-Regular.woff">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend:{
                    colors:{
                        'background-second': 'rgb(44, 45, 50)',
                        background: 'rgb(50, 51, 56)',
                        second: 'rgb(20, 253, 32)',
                    },
                    fontFamily: {
                        log: ['LOGX-10-Regular','serif'],
                    }
                }
            }
        }
    </script>
    <title>Rodrigue NZOUDA</title>
</head>
<body class="mx-auto font-log  max-w-screen-xl space-y-32 bg-background-second">
    <header class="bg-background">
        <nav x-data="{ isOpen: false}" class="flex justify-between p-4 lg:p-8 ">
            <div class="flex items-center">
                <h3 class="text-3xl text-white">
                    R.NZOUDA
                </h3>
            </div>
            <!-- left header section -->
            <div class="flex items-center justify-between">
                <button @click="isOpen = !isOpen" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white lg:hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="hidden space-x-16 lg:inline-block">
                    <a href="#" class="text-base text-white ">Acceuil</a>
                    <a href="#" class="text-base text-white ">Blogs</a>
                    <a href="#" class="text-base text-white ">Mes Projets</a>
                    <a href="#" class="text-base text-white ">A Propos</a>
                </div>
                <!-- mobile navbar-->
                <div class="mobile-navbar">
                    <!-- navbar wrapper-->
                    <div class="fixed left-0 w-full h-48 p-5  bg-background rounded-lg shadow-xl top-16"
                    x-show="isOpen"
                    @click.away = "isOpen = false">
                        <div class="flex flex-col space-y-6">
                            <a href="#" class="text-base text-white ">Acceuil</a>
                            <a href="#" class="text-base text-white ">Blogs</a>
                            <a href="#" class="text-base text-white ">Mes Projets</a>
                            <a href="#" class="text-base text-white ">A Propos</a>
                        </div>
                    </div>
                </div>
                <!--end mobile navbar-->
            </div>
            <!-- right heqder section-->
        </nav>
        <div class="hero grid md:grid-cols-1 gap-4 lg:grid-cols-3 mt-32">
            <div class="element1  space-y-12 mx-auto">
                <div class="myname font-bold text-white leading-1 text-4xl  ">
                    Rodrigue NZOUDA
                </div>
                
                <div class="social-links w-48">
                    <div class="shape h-1 bg-second w-11"></div>
                    <div class="links text-base text-lg text-white mt-2">
                    <a href="#">LinkedIn |</a>
                    <a href="#">Facebook |</a>
                    <a href="#">Twitter |</a>
                    <a href="#">Instagram |</a>
                    </div>
                </div>
                <div class="contact-bm-1">
                   <a href="#" class="btn  text-lg bg-transparent hover:bg-second text-second font-semibold hover:text-white py-2 px-4 border border-second hover:border-transparent">Me Contacter</a>
                </div>
            </div>
            <div class="element-2 ">
                <img src="./assets/svg/icon.svg" alt="">
            </div>
            <div class="element-3 ">
                <div class=" justify-center">
                    <div class="text-white text-lg pb-7 px-6 relative">
                        Salut je suis Rodrigue un jeune developpeur Camerounais passionne des technologies.
                        <br>
                        j'ai des competences dans les domaines suivants:
                    </div>
                    <div class="w-full max-w-4xl">
                      <div class="mx-auto relative w-full" x-data="carouselData([
                                 { id: 1, title: 'Developpement Frontend (VueJS, Angular, ReactJS)' },
                                 { id: 2, title: 'Developpement API NodeJS' },
                                 { id: 3, title: 'Developpement Mobile (Flutter)' },
                                 { id: 4, title: 'Developpement FullStack' }
                         ])">
                  
                        <!-- Slides -->
                        <template x-for="slide in slides" :key="slide.id">
                          <div x-show="activeSlide === slide.id" class=" font-bold text-4xl mx-16 lg:mx-0 flex items-center text-second rounded">
                            <span class="w-12 text-center" x-text="slide.title"></span>
                          </div>
                        </template>
                  
                        <!-- Prev/Next Arrows -->
                        <div class=" flex relative  pt-3">
                          <div class="flex items-center justify-end w-1/2">
                            <button @click="goToPrevious()" class=" text-white hover:text-second font-bold hover:shadow-lg rounded-full w-12 h-12 -ml-6 focus:outline-none">
                              &#8592;
                            </button>
                          </div>
                  
                          <div class="flex items-center justify-end ">
                            <button @click="goToNext()" class=" text-white hover:text-second font-bold hover:shadow-lg rounded-full w-12 h-12 -mr-6 focus:outline-none">
                              &#8594;
                            </button>
                          </div>
                        </div>
                  
                        <!-- Buttons --> <!--
                        <div class="absolute w-full flex items-center justify-center px-4 bottom-2">
                          <template x-for="slide in slides" :key="slide.id">
                            <button @click="activeSlide = slide.id" :class="{ 'bg-indigo-800': activeSlide === slide.id, 'bg-white': activeSlide !== slide.id }" class="w-4 h-2 mt-4 mx-2 mb-0 rounded-full overflow-hidden transition-colors duration-200 ease-out hover:bg-indigo-600 hover:shadow-lg focus:outline-none"></button>
                          </template>
                        </div>
                        -->
                      </div>
                    </div>
                  
                  </div>
            </div>
        </div>
    </header>
<section class="services mt-12">
    <div class="section-title text-second text-xl font-semibold text-center">
        SERVICES
    </div>
    <div class="section-subtitle text-4xl text-white text-center mt-2">
        Ce que je peux faire
    </div>
    <div class="small-desc lg:px-32 px-3 text-center text-lg text-white mt-4 ">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. rupti, deleniti expedita tempore sit voluptate molestias incidunt excepturi labore? Optio cum facilis non nemo, sint eveniet rem suscipit. Vel error fugiat qui mollitia rem consequuntur necessitatibus.
    </div>
    <div class="grid md:grid-cols-2 sm:grid-cols-1 lg:grid-cols-4 gap-4 mt-16">
        <div class="element1 bg-background">
            <div class="icon text-center flex justify-center pt-14 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="100" height="100" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path fill="currentColor" d="M10.478 1.647a.5.5 0 1 0-.956-.294l-4 13a.5.5 0 0 0 .956.294l4-13zM4.854 4.146a.5.5 0 0 1 0 .708L1.707 8l3.147 3.146a.5.5 0 0 1-.708.708l-3.5-3.5a.5.5 0 0 1 0-.708l3.5-3.5a.5.5 0 0 1 .708 0zm6.292 0a.5.5 0 0 0 0 .708L14.293 8l-3.147 3.146a.5.5 0 0 0 .708.708l3.5-3.5a.5.5 0 0 0 0-.708l-3.5-3.5a.5.5 0 0 0-.708 0z"/></svg>
            </div>
            <div class="title text-white flex mt-2 justify-center text-lg font-bold">
                Web Developpement
            </div>
            <div class="flex text-lg pb-5 justify-center text-gray-300">
                +0 Projects
            </div>
            <div class="bg-back pt-4">
                <div class="experience flex justify-center text-second text-3xl font-semibold">
                    2+
                </div>
                <div class="desc text-lg flex justify-center text-white">
                    Annee d'experiences
                </div>
            </div>
        </div>
        <div class="element1 bg-background">
            <div class="icon text-center flex justify-center pt-14 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="100" height="100" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path fill="currentColor" d="M516 673c0 4.4 3.4 8 7.5 8h185c4.1 0 7.5-3.6 7.5-8v-48c0-4.4-3.4-8-7.5-8h-185c-4.1 0-7.5 3.6-7.5 8v48zm-194.9 6.1l192-161c3.8-3.2 3.8-9.1 0-12.3l-192-160.9A7.95 7.95 0 0 0 308 351v62.7c0 2.4 1 4.6 2.9 6.1L420.7 512l-109.8 92.2a8.1 8.1 0 0 0-2.9 6.1V673c0 6.8 7.9 10.5 13.1 6.1zM880 112H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V144c0-17.7-14.3-32-32-32zm-40 728H184V184h656v656z"/></svg>
            </div>
            <div class="title text-white flex mt-2 justify-center text-lg font-bold">
                Shell scripting
            </div>
            <div class="flex text-lg pb-5 justify-center text-gray-300">
                +0 Projects
            </div>
            <div class="bg-back pt-4">
                <div class="experience flex justify-center text-second text-3xl font-semibold">
                    21+
                </div>
                <div class="desc text-lg flex justify-center text-white">
                    batch script
                </div>
            </div>
        </div>
        <div class="element1 bg-background">
            <div class="icon text-center flex justify-center pt-14 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="100" height="100" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M9 22h1v-2h-.989C8.703 19.994 6 19.827 6 16c0-1.993-.665-3.246-1.502-4C5.335 11.246 6 9.993 6 8c0-3.827 2.703-3.994 3-4h1V2H8.998C7.269 2.004 4 3.264 4 8c0 2.8-1.678 2.99-2.014 3L2 13c.082 0 2 .034 2 3c0 4.736 3.269 5.996 5 6zm13-11c-.082 0-2-.034-2-3c0-4.736-3.269-5.996-5-6h-1v2h.989c.308.006 3.011.173 3.011 4c0 1.993.665 3.246 1.502 4c-.837.754-1.502 2.007-1.502 4c0 3.827-2.703 3.994-3 4h-1v2h1.002C16.731 21.996 20 20.736 20 16c0-2.8 1.678-2.99 2.014-3L22 11z"/></svg>
            </div>
            <div class="title text-white flex mt-2 justify-center text-lg font-bold">
                Mobile Developpement
            </div>
            <div class="flex text-lg pb-5 justify-center text-gray-300">
                +0 Projects
            </div>
            <div class="bg-back pt-4">
                <div class="experience flex justify-center text-second text-3xl font-semibold">
                    2+
                </div>
                <div class="desc text-lg flex justify-center text-white">
                    Application concue
                </div>
            </div>
        </div>
        <div class="element1 bg-background">
            <div class="icon text-center flex justify-center pt-14 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="100" height="100" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12c5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
            </div>
            <div class="title text-white flex mt-2 justify-center text-lg font-bold">
                Cyber security
            </div>
            <div class="flex text-lg pb-5 justify-center text-gray-300">
                +0 Projects
            </div>
            <div class="bg-back pt-4">
                <div class="experience flex justify-center text-second text-3xl font-semibold">
                    22+
                </div>
                <div class="desc text-lg flex justify-center text-white">
                    Penetration
                </div>
            </div>
        </div>
    </div>
</section>
<section class="portfolio-section bg-background mt-5">
    <div class="section-title text-second text-xl py-5 font-semibold mt-5 text-center">
        PORTFOLIO
    </div>
    <div class="section-subtitle text-4xl text-white text-center mt-2">
        Quelques captures de mes projets
    </div>
    <div class="small-desc px-3 lg:px-32 md:text-center  text-lg text-white  text-center">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. rupti, deleniti expedita tempore sit voluptate molestias incidunt excepturi labore? Optio cum facilis .
    </div>
    <div class="categories flex justify-center p-5">
        <!--
            
        <a href="#" class="hover:text-second text-white text-lg p-2 mr-5 border-b-second border-b-2">ALL</a>
        <a href="#" class="hover:text-second text-white text-lg p-2 mr-5">Web Developpement</a>
        <a href="#" class="hover:text-second text-white text-lg p-2 mr-5">Mobile Developpement</a>
        <a href="#" class="hover:text-second text-white text-lg p-2 mr-5">Shell scripting</a>
    </div>
        -->
        <div class="grid md:grid-cols-2 sm:grid-cols-1 lg:grid-cols-3 gap-4 mt-16">
            <div class="element">
                <span class="animate-ping absolute inline-flex  h-3 w-3 rounded-full bg-gray-300 opacity-75"></span>
                <img src="https://i.pinimg.com/564x/35/5b/ac/355bac90ed3e5190fc4ff3e53200a3f3.jpg" alt="">
            </div>
            <div class="element">
                <span class="animate-ping absolute inline-flex  h-3 w-3 rounded-full bg-black opacity-75"></span>
                <img src="
                https://i.pinimg.com/564x/8d/d1/09/8dd1094adea22f2011df6e8835441bad.jpg" alt="">
                
            </div>
            <div class="element ">
                <span class="animate-ping absolute inline-flex  h-3 w-3 rounded-full bg-sky-400 opacity-75"></span>
                <img class='hover:h-72 relative inline-flex ' src="
                https://res.cloudinary.com/practicaldev/image/fetch/s--bN2frsUf--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_880/https://dev-to-uploads.s3.amazonaws.com/i/4cjdpc4vfgnmpui942ju.png" alt="">
            </div>
        </div>
</section>
    <section class="blogs">
        <div class="section-title text-second text-xl py-5 font-semibold mt-5 text-center">
            Blogs
        </div>
        <div class="section-subtitle text-4xl text-white text-center mt-2">
            Articles Recents
        </div>
        <div class="small-desc px-3 lg:px-32 md:text-center text-white text-lg mt-4   text-center">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. rupti, deleniti expedita tempore sit voluptate molestias incidunt excepturi labore? Optio cum facilis .
        </div>
        <div class="element grid md:grid-cols-2 sm:grid-cols-1 lg:grid-cols-3 gap-4 mt-16">
            <div class="twins-blog bg-background relative w-full">
                <div class="date bg-black text-second p-2 font-semibold absolute">
                    18 / 05 / 2022
                </div>
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRyy3Ra2TwdqNRURW-Vk4TO3Sz9NsqiNWVqBQ&usqp=CAU" class="w-full" alt="">
                <div class="title text-second text-xl font-bold py-7 px-5">
                    Tesla met au point un telephone du futur
                </div>
                <div class="apercu isolation-auto px-4 pb-5 text-white ">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum quaerat fugiat quis alias voluptate iusto aspernatur, adipisci rem quia ipsa molestias tenetur magnam minima animi tempora ratione, suscipit cumque inventore.
                </div>
            </div>
            <div class="twins-blog bg-background relative w-full">
                <div class="date bg-black text-second p-2 font-semibold absolute">
                    18 / 05 / 2022
                </div>
                <img src="data:image/jpeg;base64,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" class="w-full" alt="">
                <div class="title text-second text-xl font-bold py-7 px-5">
                    Rolce Royce cullinan 2022
                </div>
                <div class="apercu isolation-auto px-4 pb-5 text-white ">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum quaerat fugiat quis alias voluptate iusto aspernatur, adipisci rem quia ipsa molestias tenetur magnam minima animi tempora ratione, suscipit cumque inventore.
                </div>
            </div>
            <div class="twins-blog bg-background relative w-full">
                <div class="date bg-black text-second p-2 font-semibold absolute">
                    18 / 05 / 2022
                </div>
                <img src="data:image/jpeg;base64,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" class="w-full" alt="">
                <div class="title text-second text-xl font-bold py-7 px-5">
                    Rolce Royce cullinan 2022
                </div>
                <div class="apercu isolation-auto px-4 pb-5 text-white ">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum quaerat fugiat quis alias voluptate iusto aspernatur, adipisci rem quia ipsa molestias tenetur magnam minima animi tempora ratione, suscipit cumque inventore.
                </div>
            </div>
        </div>
    </section>
    <footer class="contact bg-background">
        <div class="section-title text-second text-xl py-5 font-semibold mt-5 text-center">
            Contacts
        </div>
        <div class="section-subtitle text-4xl text-white text-center mt-2">
            Comment me joindre
        </div>
        <div class="small-desc px-3 lg:px-32 md:text-center  text-lg text-white mt-4 md:px-32  text-center">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. rupti, deleniti expedita tempore sit voluptate molestias incidunt excepturi labore? Optio cum facilis .
        </div>
        <div class="grid grid-cols-5 gap-2  relative pt-16">
            <a href="wa.me/+237654818785" class="contact-btn ml-5 bg-background-second block m-1 p-3">
                <div class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path fill="currentColor" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608a17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42a18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zm10.762.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708z"/></svg>
                </div>
                <div class="tel px-3 text-second font-bold">
                    +237 654 818 8785
                </div>
            </a>
            <a href="https://twitter.com/RNzouda" class="contact-btn ml-5 block m-1 bg-background-second p-3">
                <div class="text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="16.25" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1231.051 1000"><path fill="currentColor" d="M1231.051 118.453q-51.422 76.487-126.173 130.403q.738 14.46.738 32.687q0 101.273-29.53 202.791q-29.53 101.519-90.215 194.343q-60.685 92.824-144.574 164.468q-83.889 71.644-201.677 114.25q-117.788 42.606-252.474 42.606q-210.2 0-387.147-113.493q31.406 3.495 60.242 3.495q175.605 0 313.687-108.177q-81.877-1.501-146.654-50.409q-64.777-48.907-89.156-124.988q24.097 4.59 47.566 4.59q33.782 0 66.482-8.812q-87.378-17.5-144.975-87.04q-57.595-69.539-57.595-160.523v-3.126q53.633 29.696 114.416 31.592q-51.762-34.508-82.079-89.999q-30.319-55.491-30.319-120.102q0-68.143 34.151-126.908q95.022 116.607 230.278 186.392q135.258 69.786 290.212 77.514q-6.609-27.543-6.621-57.485q0-104.546 73.994-178.534Q747.623 0 852.169 0q109.456 0 184.392 79.711q85.618-16.959 160.333-61.349q-28.785 90.59-110.933 139.768q75.502-8.972 145.088-39.677z"/></svg>
                </div>
                <div class="tel px-3 text-second font-bold">
                    @RNZOUDA
                </div>
            </a>
            <a href="mailto:rodriguenzouda35@gmail.com" class="contact-btn ml-5 block m-1  bg-background-second p-3">
                <div class="text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path fill="currentColor" d="M32 6v20c0 1.135-.865 2-2 2h-2V9.849l-12 8.62l-12-8.62V28H2c-1.135 0-2-.865-2-2V6c0-.568.214-1.068.573-1.422A1.973 1.973 0 0 1 2 4h.667L16 13.667L29.333 4H30c.568 0 1.068.214 1.427.578c.359.354.573.854.573 1.422z"/></svg>
                </div>
                <div class="tel w-full text-second font-bold">
                    rodriguenzouda35@gmail.com
                </div>
            </a>
            <a href="https://web.facebook.com/rodrigue.nzouda.33?_rdc=1&_rdr" class="contact-btn ml-5 block m-1  bg-background-second p-3">
                <div class="text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path fill="currentColor" d="m23.446 18l.889-5.791h-5.557V8.451c0-1.584.776-3.129 3.265-3.129h2.526V.392S22.277.001 20.085.001c-4.576 0-7.567 2.774-7.567 7.795v4.414H7.431v5.791h5.087v14h6.26v-14z"/></svg>
                </div>
                <div class="tel px-3 text-second font-bold">
                    Rodrigue NZOUDA
                </div>
            </a>
            <a href="https://www.linkedin.com/in/nzouda-rodrigue-999019197?originalSubdomain=cm" class="contact-btn ml-5 block m-1  bg-background-second p-3">
                <div class="text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><circle cx="4" cy="4" r="2" fill="currentColor" fill-opacity="0"><animate fill="freeze" attributeName="fill-opacity" dur="0.4s" values="0;1"/></circle><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="4"><path stroke-dasharray="12" stroke-dashoffset="12" d="M4 10V20"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.2s" dur="0.2s" values="12;0"/></path><path stroke-dasharray="12" stroke-dashoffset="12" d="M10 10V20"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.5s" dur="0.2s" values="12;0"/></path><path stroke-dasharray="24" stroke-dashoffset="24" d="M10 15C10 12.2386 12.2386 10 15 10C17.7614 10 20 12.2386 20 15V20"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.5s" values="24;0"/></path></g></svg>
                </div>
                <div class="tel px-3 text-second font-bold">
                    Rodrigue NZOUDA
                </div>
            </a>
        </div>
        <div class="flex justify-end mt-3">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="flex ">
                    <div id="client">
                        <div class=" flex flex-col mx-2">
                            <label for="" class="text-second">Nom & Prenom</label>
                            <input type="text" name="full_name" class="focus:ring-second focus:ring-1 text-xl text-second px-2 bg-background-second outline-none h-12 w-60 " id="">
                           <?php
                          if (isset($errors) && isset($errors['full_name'])) {
                            ?>
                                <div id="email-text-error" class="text-sm text-red-500 font-bold">
                                    <?= $errors['full_name'] ?>                     
                               </div>
                            <?php
                          }
                           ?>
                        </div>
                    </div>
                    <div class="flex flex-col mx-2">
                        <label for="" class="text-second">E-mail</label>
                        <input type="email" name="email" class=" outline-none h-12 w-60 focus:ring-second focus:ring-1 text-xl text-second px-2 bg-background-second" id="">
                        <?php
                          if (isset($errors) && isset($errors['email'])) {
                            ?>
                                <div id="email-text-error" class="text-sm text-red-500 font-bold">
                                    <?= $errors['email'] ?>                     
                               </div>
                            <?php
                          }
                           ?>
                    </div>
                    </div>
                    <div id="object" class="my-3 mx-2 flex flex-col">
                        <label for="" class="text-second">Objet</label>
                        <input type="text" name="object" class=" outline-none h-12 w-auto bg-background-second focus:ring-second focus:ring-1 text-xl text-second px-2" id="">
                        <?php
                          if (isset($errors) && isset($errors['object'])) {
                            ?>
                                <div id="email-text-error" class="text-sm text-red-500 font-bold">
                                    <?= $errors['object'] ?>                     
                               </div>
                            <?php
                          }
                           ?>
                    </div>
                    <div id="content" class="mx-2 flex flex-col">
                        <label for="" class="text-second">Entrer Votre Message</label>
                        <textarea name="message" class="outline-none h-52 w-auto bg-background-second focus:ring-second focus:ring-1 text-xl text-second px-2" id="" cols="30" rows="10"></textarea>
                        <?php
                          if (isset($errors) && isset($errors['message'])) {
                            ?>
                                <div id="email-text-error" class="text-sm text-red-500 font-bold">
                                    <?= $errors['message'] ?>                     
                               </div>
                            <?php
                          }
                           ?>
                    </div>
                    <div class="mx-2 my-4">
                        <input name="submit" type="submit" value="Submit" class="bg-background-second text-second px-4 border-second border hover:text-background-second hover:bg-second py-2 text-lg">
                    </div>
                </div>
            </form>
        </div>
    </footer>
    <script src="./assets/js/app.js"></script>
</body>
</html>