<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Online MARC editor">
    <meta name="author" content="Tiago Murakami">
    <meta name="generator" content="Boostrap and Vue">
    <title>Online MARC Editor</title>
    
    <!-- Facebook Open Graph -->
    <meta property="og:title" content="Online MARC Editor" />    

    <link rel="canonical" href="https://online-marc-editor.herokuapp.com">

    

    <!-- Bootstrap core CSS -->
    <link href="inc/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    <meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="inc/css/dashboard.css" rel="stylesheet">

    <!-- development version, includes helpful console warnings -->
    <script src="inc/js/vue.js"></script>
    <script src="inc/js/axios.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-T1LLKWFGNM"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-T1LLKWFGNM');
    </script>

  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="https://online-marc-editor.herokuapp.com" aria-current="page">Online MARC Editor</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="#">Sign out</a>
    </div>
  </div> -->
</header>

<div class="container-fluid">
  <div class="row" id="editor">
    <nav id="sidebarMenu" class="col-md-2 col-lg-1 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>{{ translation.predefined_types }}</span>
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" type="button" @click="recordType='Book';record.ldr.bibliographic_level='m';record.ldr.type_of_record='a';record.f008.p19='#';record.f008.p21='#';record.f008.p33='0';record.f008.p34='#'">
              <span data-feather="book"></span>                         
              {{ translation.book }}
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" type="button" @click="recordType='Serial';record.ldr.bibliographic_level='s';record.ldr.type_of_record='a';record.f008.p19='r';record.f008.p21='p';record.f008.p33='#';record.f008.p34='0'"> 
              <span data-feather="layers"></span>             
              {{ translation.serial }}
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>{{ translation.edit_fields }}</span>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" v-on:click="ldrShow = !ldrShow" type="button">
              <span data-feather="file-text"></span>
              {{ translation.leader }}
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" v-on:click="f008Show = !f008Show" type="button">
              <span data-feather="file-text"></span>
              {{ translation._008 }}
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" v-on:click="doiShow = !doiShow" type="button">
              <span data-feather="file-text"></span>
              DOI
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" v-on:click="isbnShow = !isbnShow" type="button">
              <span data-feather="file-text"></span>
              ISBN
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" type="button" @click="RDA=true;record._336a='text';record._337a='unmediated';record._338a='object'">
              <span data-feather="layers"></span>
              {{ translation.add_rda_fields }}
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editor</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-info" @click="translate('pt_BR')">Português</button>
            <button type="button" class="btn btn-sm btn-outline-info" @click="translate('en_US')">English</button>
            <button type="button" class="btn btn-sm btn-outline-warning" @click="validate()">Validate</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" @click="validation._245a='', errors = null">Clear validation</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" @click="cleanAll()">Clear all record</button>
            <!--
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            -->
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-7 ms-sm-auto col-lg-8 px-md-4">
              

                        <!-- 008 -->
                        <div v-show="f008Show" class="alert alert-warning alert-dismissible fade show" role="alert">

                            <label for="record_status">06 - Type of date/Publication status</label>
                            <select class="form-select" aria-label="Record status" id="record_status" v-model="record.f008.p06">
                                <option value="b">b - No dates given; B.C. date involved</option>
                                <option value="c">c - Continuing resource currently published</option>
                                <option value="d">d - Continuing resource ceased publication</option>
                                <option value="e">e - Detailed date</option>
                                <option value="i">i - Inclusive dates of collection</option>
                                <option value="k">k - Range of years of bulk of collection</option>
                                <option value="m">m - Multiple dates</option>
                                <option value="n">n - Dates unknown</option>
                                <option value="p">p - Date of distribution/release/issue and production/recording session when different</option>
                                <option value="q">q - Questionable date</option>
                                <option value="r">r - Reprint/reissue date and original date</option>
                                <option value="s">s - Single known date/probable date</option>
                                <option value="t">t - Publication date and copyright date</option>
                                <option value="i">i - Continuing resource status unknown</option>
                                <option value="|">| - No attempt to code</option>
                            </select>

                            <label for="008_07_10">07-10 - Date 1</label>
                            <input type="text" id="008_07_10" v-model="record.f008.p07_10" class="form-control" aria-label="008_07_10" aria-describedby="008_07_10" maxlength="4">

                            <label for="008_11_14">11-14 - Date 2</label>
                            <input type="text" id="008_11_14" v-model="record.f008.p11_14" class="form-control" aria-label="008_11_14" aria-describedby="008_11_14" maxlength="4">

                            <label for="008_15_17">15-17 - Place of publication, production, or execution</label>
                            <select class="form-select selectpicker" aria-label="Place of publication" id="008_15_17" v-model="record.f008.p15_17" data-live-search="true">
                                <option value="xx#">xx# - No place, unknown, or undetermined</option>
                                <option value="vp#">vp# - Various places</option>
                                <option value="bl#">bl# - Brazil</option>
                                <option value="aa#">aa# - Albania</option>
                                <option value="abc">abc - Alberta</option>
                                <option value="-ac">-ac - Ashmore and Cartier Islands</option>
                                <option value="aca">aca - Australian Capital Territory</option>
                                <option value="ae#">ae# - Algeria</option>
                                <option value="af#">af# - Afghanistan</option>
                                <option value="ag#">ag# - Argentina</option>
                                <option value="-ai">-ai - Anguilla</option>
                                <option value="ai#">ai# - Armenia (Republic)</option>
                                <option value="air">air - Armenian S.S.R.</option>
                                <option value="aj#">aj# - Azerbaijan</option>
                                <option value="ajr">ajr - Azerbaijan S.S.R.</option>
                                <option value="aku">aku - Alaska</option>
                                <option value="alu">alu - Alabama</option>
                                <option value="am#">am# - Anguilla</option>
                                <option value="an#">an# - Andorra</option>
                                <option value="ao#">ao# - Angola</option>
                                <option value="aq#">aq# - Antigua and Barbuda</option>
                                <option value="aru">aru - Arkansas</option>
                                <option value="as#">as# - American Samoa</option>
                                <option value="at#">at# - Australia</option>
                                <option value="au#">au# - Austria</option>
                                <option value="aw#">aw# - Aruba</option>
                                <option value="ay#">ay# - Antarctica</option>
                                <option value="azu">azu - Arizona</option>
                                <option value="ba#">ba# - Bahrain</option>
                                <option value="bb#">bb# - Barbados</option>
                                <option value="bcc">bcc - British Columbia</option>
                                <option value="bd#">bd# - Burundi</option>
                                <option value="be#">be# - Belgium</option>
                                <option value="bf#">bf# - Bahamas</option>
                                <option value="bg#">bg# - Bangladesh</option>
                                <option value="bh#">bh# - Belize</option>
                                <option value="bi#">bi# - British Indian Ocean Territory</option>
                                <option value="bl#">bl# - Brazil</option>
                                <option value="bm#">bm# - Bermuda Islands</option>
                                <option value="bn#">bn# - Bosnia and Herzegovina</option>
                                <option value="bo#">bo# - Bolivia</option>
                                <option value="bp#">bp# - Solomon Islands</option>
                                <option value="br#">br# - Burma</option>
                                <option value="bs#">bs# - Botswana</option>
                                <option value="bt#">bt# - Bhutan</option>
                                <option value="bu#">bu# - Bulgaria</option>
                                <option value="bv#">bv# - Bouvet Island</option>
                                <option value="bw#">bw# - Belarus</option>
                                <option value="bwr">bwr - Byelorussian S.S.R.</option>
                                <option value="bx#">bx# - Brunei</option>
                                <option value="ca#">ca# - Caribbean Netherlands</option>
                                <option value="cau">cau - California</option>
                                <option value="cb#">cb# - Cambodia</option>
                                <option value="cc#">cc# - China</option>
                                <option value="cd#">cd# - Chad</option>
                                <option value="ce#">ce# - Sri Lanka</option>
                                <option value="cf#">cf# - Congo (Brazzaville)</option>
                                <option value="cg#">cg# - Congo (Democratic Republic)</option>
                                <option value="ch#">ch# - China (Republic : 1949- )</option>
                                <option value="ci#">ci# - Croatia</option>
                                <option value="cj#">cj# - Cayman Islands</option>
                                <option value="ck#">ck# - Colombia</option>
                                <option value="cl#">cl# - Chile</option>
                                <option value="cm#">cm# - Cameroon</option>
                                <option value="-cn">-cn - Canada</option>
                                <option value="co#">co# - Curaçao</option>
                                <option value="cou">cou - Colorado</option>
                                <option value="-cp">-cp - Canton and Enderbury Islands</option>
                                <option value="cq#">cq# - Comoros</option>
                                <option value="cr#">cr# - Costa Rica</option>
                                <option value="-cs">-cs - Czechoslovakia</option>
                                <option value="ctu">ctu - Connecticut</option>
                                <option value="cu#">cu# - Cuba</option>
                                <option value="cv#">cv# - Cabo Verde</option>
                                <option value="cw#">cw# - Cook Islands</option>
                                <option value="cx#">cx# - Central African Republic</option>
                                <option value="cy#">cy# - Cyprus</option>
                                <option value="-cz">-cz - Canal Zone</option>
                                <option value="dcu">dcu - District of Columbia</option>
                                <option value="deu">deu - Delaware</option>
                                <option value="dk#">dk# - Denmark</option>
                                <option value="dm#">dm# - Benin</option>
                                <option value="dq#">dq# - Dominica</option>
                                <option value="dr#">dr# - Dominican Republic</option>
                                <option value="ea#">ea# - Eritrea</option>
                                <option value="ec#">ec# - Ecuador</option>
                                <option value="eg#">eg# - Equatorial Guinea</option>
                                <option value="em#">em# - Timor-Leste</option>
                                <option value="enk">enk - England</option>
                                <option value="er#">er# - Estonia</option>
                                <option value="err">err - Estonia</option>
                                <option value="es#">es# - El Salvador</option>
                                <option value="et#">et# - Ethiopia</option>
                                <option value="fa#">fa# - Faroe Islands</option>
                                <option value="fg#">fg# - French Guiana</option>
                                <option value="fi#">fi# - Finland</option>
                                <option value="fj#">fj# - Fiji</option>
                                <option value="fk#">fk# - Falkland Islands</option>
                                <option value="flu">flu - Florida</option>
                                <option value="fm#">fm# - Micronesia (Federated States)</option>
                                <option value="fp#">fp# - French Polynesia</option>
                                <option value="fr#">fr# - France</option>
                                <option value="fs#">fs# - Terres australes et antarctiques françaises</option>
                                <option value="ft#">ft# - Djibouti</option>
                                <option value="gau">gau - Georgia</option>
                                <option value="gb#">gb# - Kiribati</option>
                                <option value="gd#">gd# - Grenada</option>
                                <option value="-ge">-ge - Germany (East)</option>
                                <option value="gg#">gg# - Guernsey</option>
                                <option value="gh#">gh# - Ghana</option>
                                <option value="gi#">gi# - Gibraltar</option>
                                <option value="gl#">gl# - Greenland</option>
                                <option value="gm#">gm# - Gambia</option>
                                <option value="-gn">-gn - Gilbert and Ellice Islands</option>
                                <option value="go#">go# - Gabon</option>
                                <option value="gp#">gp# - Guadeloupe</option>
                                <option value="gr#">gr# - Greece</option>
                                <option value="gs#">gs# - Georgia (Republic)</option>
                                <option value="gsr">gsr - Georgian S.S.R.</option>
                                <option value="gt#">gt# - Guatemala</option>
                                <option value="gu#">gu# - Guam</option>
                                <option value="gv#">gv# - Guinea</option>
                                <option value="gw#">gw# - Germany</option>
                                <option value="gy#">gy# - Guyana</option>
                                <option value="gz#">gz# - Gaza Strip</option>
                                <option value="hiu">hiu - Hawaii</option>
                                <option value="-hk">-hk - Hong Kong</option>
                                <option value="hm#">hm# - Heard and McDonald Islands</option>
                                <option value="ho#">ho# - Honduras</option>
                                <option value="ht#">ht# - Haiti</option>
                                <option value="hu#">hu# - Hungary</option>
                                <option value="iau">iau - Iowa</option>
                                <option value="ic#">ic# - Iceland</option>
                                <option value="idu">idu - Idaho</option>
                                <option value="ie#">ie# - Ireland</option>
                                <option value="ii#">ii# - India</option>
                                <option value="ilu">ilu - Illinois</option>
                                <option value="im#">im# - Isle of Man</option>
                                <option value="inu">inu - Indiana</option>
                                <option value="io#">io# - Indonesia</option>
                                <option value="iq#">iq# - Iraq</option>
                                <option value="ir#">ir# - Iran</option>
                                <option value="is#">is# - Israel</option>
                                <option value="it#">it# - Italy</option>
                                <option value="-iu">-iu - Israel-Syria Demilitarized Zones</option>
                                <option value="iv#">iv# - Côte d'Ivoire</option>
                                <option value="-iw">-iw - Israel-Jordan Demilitarized Zones</option>
                                <option value="iy#">iy# - Iraq-Saudi Arabia Neutral Zone</option>
                                <option value="ja#">ja# - Japan</option>
                                <option value="je#">je# - Jersey</option>
                                <option value="ji#">ji# - Johnston Atoll</option>
                                <option value="jm#">jm# - Jamaica</option>
                                <option value="-jn">-jn - Jan Mayen</option>
                                <option value="jo#">jo# - Jordan</option>
                                <option value="ke#">ke# - Kenya</option>
                                <option value="kg#">kg# - Kyrgyzstan</option>
                                <option value="kgr">kgr - Kirghiz S.S.R.</option>
                                <option value="kn#">kn# - Korea (North)</option>
                                <option value="ko#">ko# - Korea (South)</option>
                                <option value="ksu">ksu - Kansas</option>
                                <option value="ku#">ku# - Kuwait</option>
                                <option value="kv#">kv# - Kosovo</option>
                                <option value="kyu">kyu - Kentucky</option>
                                <option value="kz#">kz# - Kazakhstan</option>
                                <option value="kzr">kzr - Kazakh S.S.R.</option>
                                <option value="lau">lau - Louisiana</option>
                                <option value="lb#">lb# - Liberia</option>
                                <option value="le#">le# - Lebanon</option>
                                <option value="lh#">lh# - Liechtenstein</option>
                                <option value="li#">li# - Lithuania</option>
                                <option value="lir">lir - Lithuania</option>
                                <option value="-ln">-ln - Central and Southern Line Islands</option>
                                <option value="lo#">lo# - Lesotho</option>
                                <option value="ls#">ls# - Laos</option>
                                <option value="lu#">lu# - Luxembourg</option>
                                <option value="lv#">lv# - Latvia</option>
                                <option value="lvr">lvr - Latvia</option>
                                <option value="ly#">ly# - Libya</option>
                                <option value="mau">mau - Massachusetts</option>
                                <option value="mbc">mbc - Manitoba</option>
                                <option value="mc#">mc# - Monaco</option>
                                <option value="mdu">mdu - Maryland</option>
                                <option value="meu">meu - Maine</option>
                                <option value="mf#">mf# - Mauritius</option>
                                <option value="mg#">mg# - Madagascar</option>
                                <option value="-mh">-mh - Macao</option>
                                <option value="miu">miu - Michigan</option>
                                <option value="mj#">mj# - Montserrat</option>
                                <option value="mk#">mk# - Oman</option>
                                <option value="ml#">ml# - Mali</option>
                                <option value="mm#">mm# - Malta</option>
                                <option value="mnu">mnu - Minnesota</option>
                                <option value="mo#">mo# - Montenegro</option>
                                <option value="mou">mou - Missouri</option>
                                <option value="mp#">mp# - Mongolia</option>
                                <option value="mq#">mq# - Martinique</option>
                                <option value="mr#">mr# - Morocco</option>
                                <option value="msu">msu - Mississippi</option>
                                <option value="mtu">mtu - Montana</option>
                                <option value="mu#">mu# - Mauritania</option>
                                <option value="mv#">mv# - Moldova</option>
                                <option value="mvr">mvr - Moldavian S.S.R.</option>
                                <option value="mw#">mw# - Malawi</option>
                                <option value="mx#">mx# - Mexico</option>
                                <option value="my#">my# - Malaysia</option>
                                <option value="mz#">mz# - Mozambique</option>
                                <option value="-na">-na - Netherlands Antilles</option>
                                <option value="nbu">nbu - Nebraska</option>
                                <option value="ncu">ncu - North Carolina</option>
                                <option value="ndu">ndu - North Dakota</option>
                                <option value="ne#">ne# - Netherlands</option>
                                <option value="nfc">nfc - Newfoundland and Labrador</option>
                                <option value="ng#">ng# - Niger</option>
                                <option value="nhu">nhu - New Hampshire</option>
                                <option value="nik">nik - Northern Ireland</option>
                                <option value="nju">nju - New Jersey</option>
                                <option value="nkc">nkc - New Brunswick</option>
                                <option value="nl#">nl# - New Caledonia</option>
                                <option value="-nm">-nm - Northern Mariana Islands</option>
                                <option value="nmu">nmu - New Mexico</option>
                                <option value="nn#">nn# - Vanuatu</option>
                                <option value="no#">no# - Norway</option>
                                <option value="np#">np# - Nepal</option>
                                <option value="nq#">nq# - Nicaragua</option>
                                <option value="nr#">nr# - Nigeria</option>
                                <option value="nsc">nsc - Nova Scotia</option>
                                <option value="ntc">ntc - Northwest Territories</option>
                                <option value="nu#">nu# - Nauru</option>
                                <option value="nuc">nuc - Nunavut</option>
                                <option value="nvu">nvu - Nevada</option>
                                <option value="nw#">nw# - Northern Mariana Islands</option>
                                <option value="nx#">nx# - Norfolk Island</option>
                                <option value="nyu">nyu - New York (State)</option>
                                <option value="nz#">nz# - New Zealand</option>
                                <option value="ohu">ohu - Ohio</option>
                                <option value="oku">oku - Oklahoma</option>
                                <option value="onc">onc - Ontario</option>
                                <option value="oru">oru - Oregon</option>
                                <option value="ot#">ot# - Mayotte</option>
                                <option value="pau">pau - Pennsylvania</option>
                                <option value="pc#">pc# - Pitcairn Island</option>
                                <option value="pe#">pe# - Peru</option>
                                <option value="pf#">pf# - Paracel Islands</option>
                                <option value="pg#">pg# - Guinea-Bissau</option>
                                <option value="ph#">ph# - Philippines</option>
                                <option value="pic">pic - Prince Edward Island</option>
                                <option value="pk#">pk# - Pakistan</option>
                                <option value="pl#">pl# - Poland</option>
                                <option value="pn#">pn# - Panama</option>
                                <option value="po#">po# - Portugal</option>
                                <option value="pp#">pp# - Papua New Guinea</option>
                                <option value="pr#">pr# - Puerto Rico</option>
                                <option value="-pt">-pt - Portuguese Timor</option>
                                <option value="pw#">pw# - Palau</option>
                                <option value="py#">py# - Paraguay</option>
                                <option value="qa#">qa# - Qatar</option>
                                <option value="qea">qea - Queensland</option>
                                <option value="quc">quc - Québec (Province)</option>
                                <option value="rb#">rb# - Serbia</option>
                                <option value="re#">re# - Réunion</option>
                                <option value="rh#">rh# - Zimbabwe</option>
                                <option value="riu">riu - Rhode Island</option>
                                <option value="rm#">rm# - Romania</option>
                                <option value="ru#">ru# - Russia (Federation)</option>
                                <option value="rur">rur - Russian S.F.S.R.</option>
                                <option value="rw#">rw# - Rwanda</option>
                                <option value="-ry">-ry - Ryukyu Islands, Southern</option>
                                <option value="sa#">sa# - South Africa</option>
                                <option value="-sb">-sb - Svalbard</option>
                                <option value="sc#">sc# - Saint-Barthélemy</option>
                                <option value="scu">scu - South Carolina</option>
                                <option value="sd#">sd# - South Sudan</option>
                                <option value="sdu">sdu - South Dakota</option>
                                <option value="se#">se# - Seychelles</option>
                                <option value="sf#">sf# - Sao Tome and Principe</option>
                                <option value="sg#">sg# - Senegal</option>
                                <option value="sh#">sh# - Spanish North Africa</option>
                                <option value="si#">si# - Singapore</option>
                                <option value="sj#">sj# - Sudan</option>
                                <option value="-sk">-sk - Sikkim</option>
                                <option value="sl#">sl# - Sierra Leone</option>
                                <option value="sm#">sm# - San Marino</option>
                                <option value="sn#">sn# - Sint Maarten</option>
                                <option value="snc">snc - Saskatchewan</option>
                                <option value="so#">so# - Somalia</option>
                                <option value="sp#">sp# - Spain</option>
                                <option value="sq#">sq# - Eswatini</option>
                                <option value="sr#">sr# - Surinam</option>
                                <option value="ss#">ss# - Western Sahara</option>
                                <option value="st#">st# - Saint-Martin</option>
                                <option value="stk">stk - Scotland</option>
                                <option value="su#">su# - Saudi Arabia</option>
                                <option value="-sv">-sv - Swan Islands</option>
                                <option value="sw#">sw# - Sweden</option>
                                <option value="sx#">sx# - Namibia</option>
                                <option value="sy#">sy# - Syria</option>
                                <option value="sz#">sz# - Switzerland</option>
                                <option value="ta#">ta# - Tajikistan</option>
                                <option value="tar">tar - Tajik S.S.R.</option>
                                <option value="tc#">tc# - Turks and Caicos Islands</option>
                                <option value="tg#">tg# - Togo</option>
                                <option value="th#">th# - Thailand</option>
                                <option value="ti#">ti# - Tunisia</option>
                                <option value="tk#">tk# - Turkmenistan</option>
                                <option value="tkr">tkr - Turkmen S.S.R.</option>
                                <option value="tl#">tl# - Tokelau</option>
                                <option value="tma">tma - Tasmania</option>
                                <option value="tnu">tnu - Tennessee</option>
                                <option value="to#">to# - Tonga</option>
                                <option value="tr#">tr# - Trinidad and Tobago</option>
                                <option value="ts#">ts# - United Arab Emirates</option>
                                <option value="-tt">-tt - Trust Territory of the Pacific Islands</option>
                                <option value="tu#">tu# - Turkey</option>
                                <option value="tv#">tv# - Tuvalu</option>
                                <option value="txu">txu - Texas</option>
                                <option value="tz#">tz# - Tanzania</option>
                                <option value="ua#">ua# - Egypt</option>
                                <option value="uc#">uc# - United States Misc. Caribbean Islands</option>
                                <option value="ug#">ug# - Uganda</option>
                                <option value="-ui">-ui - United Kingdom Misc. Islands</option>
                                <option value="uik">uik - United Kingdom Misc. Islands</option>
                                <option value="-uk">-uk - United Kingdom</option>
                                <option value="un#">un# - Ukraine</option>
                                <option value="unr">unr - Ukraine</option>
                                <option value="up#">up# - United States Misc. Pacific Islands</option>
                                <option value="-ur">-ur - Soviet Union</option>
                                <option value="-us">-us - United States</option>
                                <option value="utu">utu - Utah</option>
                                <option value="uv#">uv# - Burkina Faso</option>
                                <option value="uy#">uy# - Uruguay</option>
                                <option value="uz#">uz# - Uzbekistan</option>
                                <option value="uzr">uzr - Uzbek S.S.R.</option>
                                <option value="vau">vau - Virginia</option>
                                <option value="vb#">vb# - British Virgin Islands</option>
                                <option value="vc#">vc# - Vatican City</option>
                                <option value="ve#">ve# - Venezuela</option>
                                <option value="vi#">vi# - Virgin Islands of the United States</option>
                                <option value="vm#">vm# - Vietnam</option>
                                <option value="-vn">-vn - Vietnam, North</option>
                                <option value="vp#">vp# - Various places</option>
                                <option value="vra">vra - Victoria</option>
                                <option value="-vs">-vs - Vietnam, South</option>
                                <option value="vtu">vtu - Vermont</option>
                                <option value="wau">wau - Washington (State)</option>
                                <option value="-wb">-wb - West Berlin</option>
                                <option value="wea">wea - Western Australia</option>
                                <option value="wf#">wf# - Wallis and Futuna</option>
                                <option value="wiu">wiu - Wisconsin</option>
                                <option value="wj#">wj# - West Bank of the Jordan River</option>
                                <option value="wk#">wk# - Wake Island</option>
                                <option value="wlk">wlk - Wales</option>
                                <option value="ws#">ws# - Samoa</option>
                                <option value="wvu">wvu - West Virginia</option>
                                <option value="wyu">wyu - Wyoming</option>
                                <option value="xa#">xa# - Christmas Island (Indian Ocean)</option>
                                <option value="xb#">xb# - Cocos (Keeling) Islands</option>
                                <option value="xc#">xc# - Maldives</option>
                                <option value="xd#">xd# - Saint Kitts-Nevis</option>
                                <option value="xe#">xe# - Marshall Islands</option>
                                <option value="xf#">xf# - Midway Islands</option>
                                <option value="xga">xga - Coral Sea Islands Territory</option>
                                <option value="xh#">xh# - Niue</option>
                                <option value="-xi">-xi - Saint Kitts-Nevis-Anguilla</option>
                                <option value="xj#">xj# - Saint Helena</option>
                                <option value="xk#">xk# - Saint Lucia</option>
                                <option value="xl#">xl# - Saint Pierre and Miquelon</option>
                                <option value="xm#">xm# - Saint Vincent and the Grenadines</option>
                                <option value="xn#">xn# - North Macedonia</option>
                                <option value="xna">xna - New South Wales</option>
                                <option value="xo#">xo# - Slovakia</option>
                                <option value="xoa">xoa - Northern Territory</option>
                                <option value="xp#">xp# - Spratly Island</option>
                                <option value="xr#">xr# - Czech Republic</option>
                                <option value="xra">xra - South Australia</option>
                                <option value="xs#">xs# - South Georgia and the South Sandwich Islands</option>
                                <option value="xv#">xv# - Slovenia</option>
                                <option value="xx#">xx# - No place, unknown, or undetermined</option>
                                <option value="xxc">xxc - Canada</option>
                                <option value="xxk">xxk - United Kingdom</option>
                                <option value="xxr">xxr - Soviet Union</option>
                                <option value="xxu">xxu - United States</option>
                                <option value="ye#">ye# - Yemen</option>
                                <option value="ykc">ykc - Yukon Territory</option>
                                <option value="-ys">-ys - Yemen (People's Democratic Republic)</option>
                                <option value="-yu">-yu - Serbia and Montenegro</option>
                                <option value="za#">za# - Zambia</option>
                            </select>
                            <br/>
                            <template v-if="recordType === 'Book'">
                                <label for="p18">18 - Illustrations (006/01-04)</label>
                                <select class="form-select" aria-label="Illustrations" id="p18" v-model="record.f008.p18">
                                    <option value="#"># - No illustrations</option>
                                    <option value="a">a - Illustrations</option>
                                    <option value="b">b - Maps</option>
                                    <option value="c">c - Portraits</option>
                                    <option value="d">d - Charts</option>
                                    <option value="e">e - Plans</option>
                                    <option value="f">f - Plates</option>
                                    <option value="g">g - Music</option>
                                    <option value="h">h - Facsimiles</option>
                                    <option value="i">i - Coats of arms</option>
                                    <option value="j">j - Genealogical tables</option>
                                    <option value="k">k - Forms</option>
                                    <option value="l">l - Samples</option>
                                    <option value="m">m - Phonodisc, phonowire, etc.</option>
                                    <option value="o">o - Photographs</option>
                                    <option value="p">p - Illuminations</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>
                            
                                <label for="p19">19 - Illustrations (006/01-04)</label>
                                <select class="form-select" aria-label="Illustrations" id="p19" v-model="record.f008.p19">
                                    <option value="#"># - No illustrations</option>
                                    <option value="a">a - Illustrations</option>
                                    <option value="b">b - Maps</option>
                                    <option value="c">c - Portraits</option>
                                    <option value="d">d - Charts</option>
                                    <option value="e">e - Plans</option>
                                    <option value="f">f - Plates</option>
                                    <option value="g">g - Music</option>
                                    <option value="h">h - Facsimiles</option>
                                    <option value="i">i - Coats of arms</option>
                                    <option value="j">j - Genealogical tables</option>
                                    <option value="k">k - Forms</option>
                                    <option value="l">l - Samples</option>
                                    <option value="m">m - Phonodisc, phonowire, etc.</option>
                                    <option value="o">o - Photographs</option>
                                    <option value="p">p - Illuminations</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>
                                <label for="p20">20 - Illustrations (006/01-04)</label>
                                <select class="form-select" aria-label="Illustrations" id="p20" v-model="record.f008.p20">
                                    <option value="#"># - No illustrations</option>
                                    <option value="a">a - Illustrations</option>
                                    <option value="b">b - Maps</option>
                                    <option value="c">c - Portraits</option>
                                    <option value="d">d - Charts</option>
                                    <option value="e">e - Plans</option>
                                    <option value="f">f - Plates</option>
                                    <option value="g">g - Music</option>
                                    <option value="h">h - Facsimiles</option>
                                    <option value="i">i - Coats of arms</option>
                                    <option value="j">j - Genealogical tables</option>
                                    <option value="k">k - Forms</option>
                                    <option value="l">l - Samples</option>
                                    <option value="m">m - Phonodisc, phonowire, etc.</option>
                                    <option value="o">o - Photographs</option>
                                    <option value="p">p - Illuminations</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>
                                <label for="p21">21 - Illustrations (006/01-04)</label>
                                <select class="form-select" aria-label="Illustrations" id="p21" v-model="record.f008.p21">
                                    <option value="#"># - No illustrations</option>
                                    <option value="a">a - Illustrations</option>
                                    <option value="b">b - Maps</option>
                                    <option value="c">c - Portraits</option>
                                    <option value="d">d - Charts</option>
                                    <option value="e">e - Plans</option>
                                    <option value="f">f - Plates</option>
                                    <option value="g">g - Music</option>
                                    <option value="h">h - Facsimiles</option>
                                    <option value="i">i - Coats of arms</option>
                                    <option value="j">j - Genealogical tables</option>
                                    <option value="k">k - Forms</option>
                                    <option value="l">l - Samples</option>
                                    <option value="m">m - Phonodisc, phonowire, etc.</option>
                                    <option value="o">o - Photographs</option>
                                    <option value="p">p - Illuminations</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p22">22 - Target audience (006/05)</label>
                                <select class="form-select" aria-label="Target audience" id="p22" v-model="record.f008.p22">
                                    <option value="#"># - Unknown or not specified</option>
                                    <option value="a">a - Preschool</option>
                                    <option value="b">b - Primary</option>
                                    <option value="c">c - Pre-adolescent</option>
                                    <option value="d">d - Adolescent</option>
                                    <option value="e">e - Adult</option>
                                    <option value="f">f - Specialized</option>
                                    <option value="g">g - General</option>
                                    <option value="j">j - Juvenile</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p23">23 - Form of item (006/06)</label>
                                <select class="form-select" aria-label="Form of item" id="p23" v-model="record.f008.p23">
                                    <option value="#"># - None of the following</option>
                                    <option value="a">a - Microfilm</option>
                                    <option value="b">b - Microfiche</option>
                                    <option value="c">c - Microopaque</option>
                                    <option value="d">d - Large print</option>
                                    <option value="f">f - Braille</option>
                                    <option value="o">o - Online</option>
                                    <option value="q">q - Direct electronic</option>
                                    <option value="r">r - Regular print reproduction</option>
                                    <option value="s">s - Electronic</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p24">24 - Nature of contents (006/07-10)</label>
                                <select class="form-select" aria-label="Nature of contents" id="p24" v-model="record.f008.p24">
                                    <option value="#"># - No specified nature of contents</option>
                                    <option value="a">a - Abstracts/summaries</option>
                                    <option value="b">b - Bibliographies</option>
                                    <option value="c">c - Catalogs</option>
                                    <option value="d">d - Dictionaries</option>
                                    <option value="e">e - Encyclopedias</option>
                                    <option value="f">f - Handbooks</option>
                                    <option value="g">g - Legal articles</option>
                                    <option value="i">i - Indexes</option>
                                    <option value="j">j - Patent document</option>
                                    <option value="k">k - Discographies</option>
                                    <option value="l">l - Legislation</option>
                                    <option value="m">m - Theses</option>
                                    <option value="n">n - Surveys of literature in a subject area</option>
                                    <option value="o">o - Reviews</option>
                                    <option value="p">p - Programmed texts</option>
                                    <option value="q">q - Filmographies</option>
                                    <option value="r">r - Directories</option>
                                    <option value="s">s - Statistics</option>
                                    <option value="t">t - Technical reports</option>
                                    <option value="u">u - Standards/specifications</option>
                                    <option value="v">v - Legal cases and case notes</option>
                                    <option value="w">w - Law reports and digests</option>
                                    <option value="y">y - Yearbooks</option>
                                    <option value="z">z - Treaties</option>
                                    <option value="2">2 - Offprints</option>
                                    <option value="5">5 - Calendars</option>
                                    <option value="6">6 - Comics/graphic novels</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p25">25 - Nature of contents (006/07-10)</label>
                                <select class="form-select" aria-label="Nature of contents" id="p25" v-model="record.f008.p25">
                                    <option value="#"># - No specified nature of contents</option>
                                    <option value="a">a - Abstracts/summaries</option>
                                    <option value="b">b - Bibliographies</option>
                                    <option value="c">c - Catalogs</option>
                                    <option value="d">d - Dictionaries</option>
                                    <option value="e">e - Encyclopedias</option>
                                    <option value="f">f - Handbooks</option>
                                    <option value="g">g - Legal articles</option>
                                    <option value="i">i - Indexes</option>
                                    <option value="j">j - Patent document</option>
                                    <option value="k">k - Discographies</option>
                                    <option value="l">l - Legislation</option>
                                    <option value="m">m - Theses</option>
                                    <option value="n">n - Surveys of literature in a subject area</option>
                                    <option value="o">o - Reviews</option>
                                    <option value="p">p - Programmed texts</option>
                                    <option value="q">q - Filmographies</option>
                                    <option value="r">r - Directories</option>
                                    <option value="s">s - Statistics</option>
                                    <option value="t">t - Technical reports</option>
                                    <option value="u">u - Standards/specifications</option>
                                    <option value="v">v - Legal cases and case notes</option>
                                    <option value="w">w - Law reports and digests</option>
                                    <option value="y">y - Yearbooks</option>
                                    <option value="z">z - Treaties</option>
                                    <option value="2">2 - Offprints</option>
                                    <option value="5">5 - Calendars</option>
                                    <option value="6">6 - Comics/graphic novels</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>
                    
                                <label for="p26">26 - Nature of contents (006/07-10)</label>
                                <select class="form-select" aria-label="Nature of contents" id="p26" v-model="record.f008.p26">
                                    <option value="#"># - No specified nature of contents</option>
                                    <option value="a">a - Abstracts/summaries</option>
                                    <option value="b">b - Bibliographies</option>
                                    <option value="c">c - Catalogs</option>
                                    <option value="d">d - Dictionaries</option>
                                    <option value="e">e - Encyclopedias</option>
                                    <option value="f">f - Handbooks</option>
                                    <option value="g">g - Legal articles</option>
                                    <option value="i">i - Indexes</option>
                                    <option value="j">j - Patent document</option>
                                    <option value="k">k - Discographies</option>
                                    <option value="l">l - Legislation</option>
                                    <option value="m">m - Theses</option>
                                    <option value="n">n - Surveys of literature in a subject area</option>
                                    <option value="o">o - Reviews</option>
                                    <option value="p">p - Programmed texts</option>
                                    <option value="q">q - Filmographies</option>
                                    <option value="r">r - Directories</option>
                                    <option value="s">s - Statistics</option>
                                    <option value="t">t - Technical reports</option>
                                    <option value="u">u - Standards/specifications</option>
                                    <option value="v">v - Legal cases and case notes</option>
                                    <option value="w">w - Law reports and digests</option>
                                    <option value="y">y - Yearbooks</option>
                                    <option value="z">z - Treaties</option>
                                    <option value="2">2 - Offprints</option>
                                    <option value="5">5 - Calendars</option>
                                    <option value="6">6 - Comics/graphic novels</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p27">27 - Nature of contents (006/07-10)</label>
                                <select class="form-select" aria-label="Nature of contents" id="p27" v-model="record.f008.p27">
                                    <option value="#"># - No specified nature of contents</option>
                                    <option value="a">a - Abstracts/summaries</option>
                                    <option value="b">b - Bibliographies</option>
                                    <option value="c">c - Catalogs</option>
                                    <option value="d">d - Dictionaries</option>
                                    <option value="e">e - Encyclopedias</option>
                                    <option value="f">f - Handbooks</option>
                                    <option value="g">g - Legal articles</option>
                                    <option value="i">i - Indexes</option>
                                    <option value="j">j - Patent document</option>
                                    <option value="k">k - Discographies</option>
                                    <option value="l">l - Legislation</option>
                                    <option value="m">m - Theses</option>
                                    <option value="n">n - Surveys of literature in a subject area</option>
                                    <option value="o">o - Reviews</option>
                                    <option value="p">p - Programmed texts</option>
                                    <option value="q">q - Filmographies</option>
                                    <option value="r">r - Directories</option>
                                    <option value="s">s - Statistics</option>
                                    <option value="t">t - Technical reports</option>
                                    <option value="u">u - Standards/specifications</option>
                                    <option value="v">v - Legal cases and case notes</option>
                                    <option value="w">w - Law reports and digests</option>
                                    <option value="y">y - Yearbooks</option>
                                    <option value="z">z - Treaties</option>
                                    <option value="2">2 - Offprints</option>
                                    <option value="5">5 - Calendars</option>
                                    <option value="6">6 - Comics/graphic novels</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p28">28 - Government publication (006/11)</label>
                                <select class="form-select" aria-label="Government publication" id="p28" v-model="record.f008.p28">
                                    <option value="#"># - Not a government publication</option>
                                    <option value="a">a - Autonomous or semi-autonomous component</option>
                                    <option value="c">c - Multilocal</option>
                                    <option value="f">f - Federal/national</option>
                                    <option value="i">i - International intergovernmental</option>
                                    <option value="l">l - Local</option>
                                    <option value="m">m - Multistate</option>
                                    <option value="o">o - Government publication-level undetermined</option>
                                    <option value="s">s - State, provincial, territorial, dependent, etc.</option>
                                    <option value="u">u - Unknown if item is government publication</option>
                                    <option value="z">z - Other</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p29">29 - Conference publication (006/12)</label>
                                <select class="form-select" aria-label="Conference publication" id="p29" v-model="record.f008.p29">
                                    <option value="0">0 - Not a conference publication</option>
                                    <option value="1">1 - Conference publication</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p30">30 - Festschrift (006/13)</label>
                                <select class="form-select" aria-label="Festschrift" id="p30" v-model="record.f008.p30">
                                    <option value="0">0 - Not a festschrift</option>
                                    <option value="1">1 - Festschrift</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>
                     
                                <label for="p31">31 - Index (006/14)</label>
                                <select class="form-select" aria-label="Index" id="p31" v-model="record.f008.p31">
                                    <option value="0">0 - No index</option>
                                    <option value="1">1 - Index present</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p33">33 - Literary form (006/16)</label>
                                <select class="form-select" aria-label="Literary form" id="p33" v-model="record.f008.p33">
                                    <option value="0">0 - Not fiction (not further specified)</option>
                                    <option value="1">1 - Fiction (not further specified)</option>
                                    <option value="d">d - Dramas</option>
                                    <option value="e">e - Essays</option>
                                    <option value="f">f - Novels</option>
                                    <option value="h">h - Humor, satires, etc.</option>
                                    <option value="i">i - Letters</option>
                                    <option value="j">j - Short stories</option>
                                    <option value="m">m - Mixed forms</option>
                                    <option value="p">p - Poetry</option>
                                    <option value="s">s - Speeches</option>
                                    <option value="u">u - Unknown</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p34">34 - Biography (006/17)</label>
                                <select class="form-select" aria-label="Biography" id="p34" v-model="record.f008.p34">
                                    <option value="#"># - No biographical material</option>
                                    <option value="a">a - Autobiography</option>
                                    <option value="b">b - Individual biography</option>
                                    <option value="c">c - Collective biography</option>
                                    <option value="d">d - Contains biographical information</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>
                            </template>
                            <template v-if="recordType === 'Serial'">

                                <label for="p18">18 - Frequency (006/01)</label>
                                <select class="form-select" aria-label="Frequency" id="p18" v-model="record.f008.p18">
                                    <option value="#"># - No determinable frequency</option>
                                    <option value="a">a - Annual</option>
                                    <option value="b">b - Bimonthly</option>
                                    <option value="c">c - Semiweekly</option>
                                    <option value="d">d - Daily</option>
                                    <option value="e">e - Biweekly</option>
                                    <option value="f">f - Semiannual</option>
                                    <option value="g">g - Biennial</option>
                                    <option value="h">h - Triennial</option>
                                    <option value="i">i - Three times a week</option>
                                    <option value="j">j - Three times a month</option>
                                    <option value="k">k - Continuously updated</option>
                                    <option value="m">m - Monthly</option>
                                    <option value="q">q - Quarterly</option>
                                    <option value="s">s - Semimonthly</option>
                                    <option value="t">t - Three times a year</option>
                                    <option value="u">u - Unknown</option>
                                    <option value="w">w - Weekly</option>
                                    <option value="z">z - Other</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p19">19 - Regularity (006/02)</label>
                                <select class="form-select" aria-label="Regularity" id="p19" v-model="record.f008.p19">
                                    <option value="n">n - Normalized irregular</option>
                                    <option value="r">r - Regular</option>
                                    <option value="u">u - Unknown</option>
                                    <option value="x">x - Completely irregular</option>
                                    <option value="|">| - No attempt to code </option>
                                </select>

                                <label for="p21">21 - Type of continuing resource (006/04)</label>
                                <select class="form-select" aria-label="Type of continuing resource" id="p21" v-model="record.f008.p21">
                                    <option value="#"># - None of the following</option>
                                    <option value="d">d - Updating database</option>
                                    <option value="g">g - Magazine</option>
                                    <option value="h">h - Blog</option>
                                    <option value="j">j - Journal</option>
                                    <option value="l">l - Updating loose-leaf</option>
                                    <option value="m">m - Monographic series</option>
                                    <option value="n">n - Newspaper</option>
                                    <option value="p">p - Periodical</option>
                                    <option value="r">r - Repository</option>
                                    <option value="s">s - Newsletter</option>
                                    <option value="t">t - Directory</option>
                                    <option value="w">w - Updating Web site</option>
                                    <option value="|">| - No attempt to code </option>
                                </select>

                                <label for="p22">22 - Form of original item (006/05)</label>
                                <select class="form-select" aria-label="Form of original item" id="p22" v-model="record.f008.p22">
                                    <option value="#"># - None of the following</option>
                                    <option value="a">a - Microfilm</option>
                                    <option value="b">b - Microfiche</option>
                                    <option value="c">c - Microopaque</option>
                                    <option value="d">d - Large print</option>
                                    <option value="e">e - Newspaper format</option>
                                    <option value="f">f - Braille</option>
                                    <option value="o">o - Online</option>
                                    <option value="q">q - Direct electronic</option>
                                    <option value="s">s - Electronic</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p23">23 - Form of item (006/06)</label>
                                <select class="form-select" aria-label="Form of item" id="p23" v-model="record.f008.p23">
                                    <option value="#"># - None of the following</option>
                                    <option value="a">a - Microfilm</option>
                                    <option value="b">b - Microfiche</option>
                                    <option value="c">c - Microopaque</option>
                                    <option value="d">d - Large print</option>                                    
                                    <option value="f">f - Braille</option>
                                    <option value="o">o - Online</option>
                                    <option value="q">q - Direct electronic</option>
                                    <option value="r">r - Regular print reproduction</option>
                                    <option value="s">s - Electronic</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p24">24 - Nature of entire work (006/07)</label>
                                <select class="form-select" aria-label="Nature of entire work" id="p24" v-model="record.f008.p24">
                                    <option value="#"># - No specified nature of contents</option>
                                    <option value="a">a - Abstracts/summaries</option>
                                    <option value="b">b - Bibliographies</option>
                                    <option value="c">c - Catalogs</option>
                                    <option value="d">d - Dictionaries</option>
                                    <option value="e">e - Encyclopedias</option>
                                    <option value="f">f - Handbooks</option>
                                    <option value="g">g - Legal articles</option>
                                    <option value="h">h - Biography</option>
                                    <option value="i">i - Indexes</option>
                                    <option value="j">j - Patent document</option>
                                    <option value="k">k - Discographies</option>
                                    <option value="l">l - Legislation</option>
                                    <option value="m">m - Theses</option>
                                    <option value="n">n - Surveys of literature in a subject area</option>
                                    <option value="o">o - Reviews</option>
                                    <option value="p">p - Programmed texts</option>
                                    <option value="q">q - Filmographies</option>
                                    <option value="r">r - Directories</option>
                                    <option value="s">s - Statistics</option>
                                    <option value="t">t - Technical reports</option>
                                    <option value="u">u - Standards/specifications</option>
                                    <option value="v">v - Legal cases and case notes</option>
                                    <option value="w">w - Law reports and digests</option>
                                    <option value="y">y - Yearbooks</option>
                                    <option value="z">z - Treaties</option>
                                    <option value="5">5 - Calendars</option>
                                    <option value="6">6 - Comics/graphic novels</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p25">25 - Nature of contents (006/07-10)</label>
                                <select class="form-select" aria-label="Nature of contents" id="p25" v-model="record.f008.p25">
                                <option value="#"># - No specified nature of contents</option>
                                    <option value="a">a - Abstracts/summaries</option>
                                    <option value="b">b - Bibliographies</option>
                                    <option value="c">c - Catalogs</option>
                                    <option value="d">d - Dictionaries</option>
                                    <option value="e">e - Encyclopedias</option>
                                    <option value="f">f - Handbooks</option>
                                    <option value="g">g - Legal articles</option>
                                    <option value="h">h - Biography</option>
                                    <option value="i">i - Indexes</option>
                                    <option value="j">j - Patent document</option>
                                    <option value="k">k - Discographies</option>
                                    <option value="l">l - Legislation</option>
                                    <option value="m">m - Theses</option>
                                    <option value="n">n - Surveys of literature in a subject area</option>
                                    <option value="o">o - Reviews</option>
                                    <option value="p">p - Programmed texts</option>
                                    <option value="q">q - Filmographies</option>
                                    <option value="r">r - Directories</option>
                                    <option value="s">s - Statistics</option>
                                    <option value="t">t - Technical reports</option>
                                    <option value="u">u - Standards/specifications</option>
                                    <option value="v">v - Legal cases and case notes</option>
                                    <option value="w">w - Law reports and digests</option>
                                    <option value="y">y - Yearbooks</option>
                                    <option value="z">z - Treaties</option>
                                    <option value="5">5 - Calendars</option>
                                    <option value="6">6 - Comics/graphic novels</option>
                                    <option value="|||">||| - No attempt to code</option>
                                </select>

                                <label for="p26">26 - Nature of contents (006/07-10)</label>
                                <select class="form-select" aria-label="Nature of contents" id="p26" v-model="record.f008.p26">
                                <option value="#"># - No specified nature of contents</option>
                                    <option value="a">a - Abstracts/summaries</option>
                                    <option value="b">b - Bibliographies</option>
                                    <option value="c">c - Catalogs</option>
                                    <option value="d">d - Dictionaries</option>
                                    <option value="e">e - Encyclopedias</option>
                                    <option value="f">f - Handbooks</option>
                                    <option value="g">g - Legal articles</option>
                                    <option value="h">h - Biography</option>
                                    <option value="i">i - Indexes</option>
                                    <option value="j">j - Patent document</option>
                                    <option value="k">k - Discographies</option>
                                    <option value="l">l - Legislation</option>
                                    <option value="m">m - Theses</option>
                                    <option value="n">n - Surveys of literature in a subject area</option>
                                    <option value="o">o - Reviews</option>
                                    <option value="p">p - Programmed texts</option>
                                    <option value="q">q - Filmographies</option>
                                    <option value="r">r - Directories</option>
                                    <option value="s">s - Statistics</option>
                                    <option value="t">t - Technical reports</option>
                                    <option value="u">u - Standards/specifications</option>
                                    <option value="v">v - Legal cases and case notes</option>
                                    <option value="w">w - Law reports and digests</option>
                                    <option value="y">y - Yearbooks</option>
                                    <option value="z">z - Treaties</option>
                                    <option value="5">5 - Calendars</option>
                                    <option value="6">6 - Comics/graphic novels</option>
                                    <option value="|||">||| - No attempt to code</option>
                                </select>

                                <label for="p27">27 - Nature of contents (006/07-10)</label>
                                <select class="form-select" aria-label="Nature of contents" id="p27" v-model="record.f008.p27">
                                <option value="#"># - No specified nature of contents</option>
                                    <option value="a">a - Abstracts/summaries</option>
                                    <option value="b">b - Bibliographies</option>
                                    <option value="c">c - Catalogs</option>
                                    <option value="d">d - Dictionaries</option>
                                    <option value="e">e - Encyclopedias</option>
                                    <option value="f">f - Handbooks</option>
                                    <option value="g">g - Legal articles</option>
                                    <option value="h">h - Biography</option>
                                    <option value="i">i - Indexes</option>
                                    <option value="j">j - Patent document</option>
                                    <option value="k">k - Discographies</option>
                                    <option value="l">l - Legislation</option>
                                    <option value="m">m - Theses</option>
                                    <option value="n">n - Surveys of literature in a subject area</option>
                                    <option value="o">o - Reviews</option>
                                    <option value="p">p - Programmed texts</option>
                                    <option value="q">q - Filmographies</option>
                                    <option value="r">r - Directories</option>
                                    <option value="s">s - Statistics</option>
                                    <option value="t">t - Technical reports</option>
                                    <option value="u">u - Standards/specifications</option>
                                    <option value="v">v - Legal cases and case notes</option>
                                    <option value="w">w - Law reports and digests</option>
                                    <option value="y">y - Yearbooks</option>
                                    <option value="z">z - Treaties</option>
                                    <option value="5">5 - Calendars</option>
                                    <option value="6">6 - Comics/graphic novels</option>
                                    <option value="|||">||| - No attempt to code</option>
                                </select>

                                <label for="p28">28 - Government publication (006/11)</label>
                                <select class="form-select" aria-label="Government publication" id="p28" v-model="record.f008.p28">
                                    <option value="#"># - Not a government publication</option>
                                    <option value="a">a - Autonomous or semi-autonomous component</option>
                                    <option value="c">c - Multilocal</option>
                                    <option value="f">f - Federal/national</option>
                                    <option value="i">i - International intergovernmental</option>
                                    <option value="l">l - Local</option>
                                    <option value="m">m - Multistate</option>
                                    <option value="o">o - Government publication-level undetermined</option>
                                    <option value="s">s - State, provincial, territorial, dependent, etc.</option>
                                    <option value="u">u - Unknown if item is government publication</option>
                                    <option value="z">z - Other</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p29">29 - Conference publication (006/12)</label>
                                <select class="form-select" aria-label="Conference publication" id="p29" v-model="record.f008.p29">
                                    <option value="0">0 - Not a conference publication</option>
                                    <option value="1">1 - Conference publication</option>
                                    <option value="|">| - No attempt to code</option>
                                </select>

                                <label for="p33">33 - Original alphabet or script of title (006/16)</label>
                                <select class="form-select" aria-label="Original alphabet or script of title" id="p33" v-model="record.f008.p33">
                                    <option value="#"># - No alphabet or script given/No key title</option>
                                    <option value="a">a - Basic Roman</option>
                                    <option value="b">b - Extended Roman</option>
                                    <option value="c">c - Cyrillic</option>
                                    <option value="d">d - Japanese</option>
                                    <option value="e">e - Chinese</option>
                                    <option value="f">f - Arabic</option>
                                    <option value="g">g - Greek</option>
                                    <option value="h">h - Hebrew</option>
                                    <option value="i">i - Thai</option>
                                    <option value="j">j - Devanagari</option>
                                    <option value="k">k - Korean</option>
                                    <option value="l">l - Tamil</option>
                                    <option value="u">u - Unknown</option>
                                    <option value="z">z - Other</option>
                                    <option value="|">| - No attempt to code </option>
                                </select>

                                <label for="p34">34 - Entry convention (006/17)</label>
                                <select class="form-select" aria-label="Entry convention" id="p34" v-model="record.f008.p34">
                                    <option value="0">0 - Successive entry</option>
                                    <option value="1">1 - Latest entry</option>
                                    <option value="2">2 - Integrated entry</option>
                                    <option value="|">| - No attempt to code </option>
                                </select>


                            </template>

                            <label for="008_35_37">35-37 - Language</label>
                            <select class="form-select selectpicker" aria-label="Place of publication" id="008_35_37" v-model="record.f008.p35_37" data-live-search="true">
                                <option value="por">por - Portuguese</option>
                                <option value="eng">eng - English</option>
                                <option value="###">### - No information provided</option>
                                <option value="zxx">zxx - No linguistic content</option>
                                <option value="mul">mul - Multiple languages</option>
                                <option value="sgn">sgn - Sign languages</option>
                                <option value="und">und - Undetermined</option>
                                <option value="|||">||| - No attempt to code</option>
                                <option value="por">por - Portuguese</option>
                                <option value="aar">aar - Afar</option>
                                <option value="abk">abk - Abkhaz</option>
                                <option value="ace">ace - Achinese</option>
                                <option value="ach">ach - Acoli</option>
                                <option value="ada">ada - Adangme</option>
                                <option value="ady">ady - Adygei</option>
                                <option value="afa">afa - Afroasiatic (Other)</option>
                                <option value="afh">afh - Afrihili (Artificial language)</option>
                                <option value="afr">afr - Afrikaans</option>
                                <option value="ain">ain - Ainu</option>
                                <option value="ajm">ajm - Aljamía</option>
                                <option value="aka">aka - Akan</option>
                                <option value="akk">akk - Akkadian</option>
                                <option value="alb">alb - Albanian</option>
                                <option value="ale">ale - Aleut</option>
                                <option value="alg">alg - Algonquian (Other)</option>
                                <option value="alt">alt - Altai</option>
                                <option value="amh">amh - Amharic</option>
                                <option value="ang">ang - English, Old (ca. 4501100)</option>
                                <option value="anp">anp - Angika</option>
                                <option value="apa">apa - Apache languages</option>
                                <option value="ara">ara - Arabic</option>
                                <option value="arc">arc - Aramaic</option>
                                <option value="arg">arg - Aragonese</option>
                                <option value="arm">arm - Armenian</option>
                                <option value="arn">arn - Mapuche</option>
                                <option value="arp">arp - Arapaho</option>
                                <option value="art">art - Artificial (Other)</option>
                                <option value="arw">arw - Arawak</option>
                                <option value="asm">asm - Assamese</option>
                                <option value="ast">ast - Bable</option>
                                <option value="ath">ath - Athapascan (Other)</option>
                                <option value="aus">aus - Australian languages</option>
                                <option value="ava">ava - Avaric</option>
                                <option value="ave">ave - Avestan</option>
                                <option value="awa">awa - Awadhi</option>
                                <option value="aym">aym - Aymara</option>
                                <option value="aze">aze - Azerbaijani</option>
                                <option value="bad">bad - Banda languages</option>
                                <option value="bai">bai - Bamileke languages</option>
                                <option value="bak">bak - Bashkir</option>
                                <option value="bal">bal - Baluchi</option>
                                <option value="bam">bam - Bambara</option>
                                <option value="ban">ban - Balinese</option>
                                <option value="baq">baq - Basque</option>
                                <option value="bas">bas - Basa</option>
                                <option value="bat">bat - Baltic (Other)</option>
                                <option value="bej">bej - Beja</option>
                                <option value="bel">bel - Belarusian</option>
                                <option value="bem">bem - Bemba</option>
                                <option value="ben">ben - Bengali</option>
                                <option value="ber">ber - Berber (Other)</option>
                                <option value="bho">bho - Bhojpuri</option>
                                <option value="bih">bih - Bihari (Other)</option>
                                <option value="bik">bik - Bikol</option>
                                <option value="bin">bin - Edo</option>
                                <option value="bis">bis - Bislama</option>
                                <option value="bla">bla - Siksika</option>
                                <option value="bnt">bnt - Bantu (Other)</option>
                                <option value="bos">bos - Bosnian</option>
                                <option value="bra">bra - Braj</option>
                                <option value="bre">bre - Breton</option>
                                <option value="btk">btk - Batak</option>
                                <option value="bua">bua - Buriat</option>
                                <option value="bug">bug - Bugis</option>
                                <option value="bul">bul - Bulgarian</option>
                                <option value="bur">bur - Burmese</option>
                                <option value="byn">byn - Bilin</option>
                                <option value="cad">cad - Caddo</option>
                                <option value="cai">cai - Central American Indian (Other)</option>
                                <option value="cam">cam - Khmer</option>
                                <option value="car">car - Carib</option>
                                <option value="cat">cat - Catalan</option>
                                <option value="cau">cau - Caucasian (Other)</option>
                                <option value="ceb">ceb - Cebuano</option>
                                <option value="cel">cel - Celtic (Other)</option>
                                <option value="cha">cha - Chamorro</option>
                                <option value="chb">chb - Chibcha</option>
                                <option value="che">che - Chechen</option>
                                <option value="chg">chg - Chagatai</option>
                                <option value="chi">chi - Chinese</option>
                                <option value="chk">chk - Chuukese</option>
                                <option value="chm">chm - Mari</option>
                                <option value="chn">chn - Chinook jargon</option>
                                <option value="cho">cho - Choctaw</option>
                                <option value="chp">chp - Chipewyan</option>
                                <option value="chr">chr - Cherokee</option>
                                <option value="chu">chu - Church Slavic</option>
                                <option value="chv">chv - Chuvash</option>
                                <option value="chy">chy - Cheyenne</option>
                                <option value="cmc">cmc - Chamic languages</option>
                                <option value="cnr">cnr - Montenegrin</option>
                                <option value="cop">cop - Coptic</option>
                                <option value="cor">cor - Cornish</option>
                                <option value="cos">cos - Corsican</option>
                                <option value="cpe">cpe - Creoles and Pidgins, Englishbased (Other)</option>
                                <option value="cpf">cpf - Creoles and Pidgins, Frenchbased (Other)</option>
                                <option value="cpp">cpp - Creoles and Pidgins, Portuguesebased (Other)</option>
                                <option value="cre">cre - Cree</option>
                                <option value="crh">crh - Crimean Tatar</option>
                                <option value="crp">crp - Creoles and Pidgins (Other)</option>
                                <option value="csb">csb - Kashubian</option>
                                <option value="cus">cus - Cushitic (Other)</option>
                                <option value="cze">cze - Czech</option>
                                <option value="dak">dak - Dakota</option>
                                <option value="dan">dan - Danish</option>
                                <option value="dar">dar - Dargwa</option>
                                <option value="day">day - Dayak</option>
                                <option value="del">del - Delaware</option>
                                <option value="den">den - Slavey</option>
                                <option value="dgr">dgr - Dogrib</option>
                                <option value="din">din - Dinka</option>
                                <option value="div">div - Divehi</option>
                                <option value="doi">doi - Dogri</option>
                                <option value="dra">dra - Dravidian (Other)</option>
                                <option value="dsb">dsb - Lower Sorbian</option>
                                <option value="dua">dua - Duala</option>
                                <option value="dum">dum - Dutch, Middle (ca. 10501350)</option>
                                <option value="dut">dut - Dutch</option>
                                <option value="dyu">dyu - Dyula</option>
                                <option value="dzo">dzo - Dzongkha</option>
                                <option value="efi">efi - Efik</option>
                                <option value="egy">egy - Egyptian</option>
                                <option value="eka">eka - Ekajuk</option>
                                <option value="elx">elx - Elamite</option>
                                <option value="eng">eng - English</option>
                                <option value="enm">enm - English, Middle (11001500)</option>
                                <option value="epo">epo - Esperanto</option>
                                <option value="esk">esk - Eskimo languages</option>
                                <option value="esp">esp - Esperanto</option>
                                <option value="est">est - Estonian</option>
                                <option value="eth">eth - Ethiopic</option>
                                <option value="ewe">ewe - Ewe</option>
                                <option value="ewo">ewo - Ewondo</option>
                                <option value="fan">fan - Fang</option>
                                <option value="fao">fao - Faroese</option>
                                <option value="far">far - Faroese</option>
                                <option value="fat">fat - Fanti</option>
                                <option value="fij">fij - Fijian</option>
                                <option value="fil">fil - Filipino</option>
                                <option value="fin">fin - Finnish</option>
                                <option value="fiu">fiu - FinnoUgrian (Other)</option>
                                <option value="fon">fon - Fon</option>
                                <option value="fre">fre - French</option>
                                <option value="fri">fri - Frisian</option>
                                <option value="frm">frm - French, Middle (ca. 13001600)</option>
                                <option value="fro">fro - French, Old (ca. 8421300)</option>
                                <option value="frr">frr - North Frisian</option>
                                <option value="frs">frs - East Frisian</option>
                                <option value="fry">fry - Frisian</option>
                                <option value="ful">ful - Fula</option>
                                <option value="fur">fur - Friulian</option>
                                <option value="gaa">gaa - Gã</option>
                                <option value="gae">gae - Scottish Gaelix</option>
                                <option value="gag">gag - Galician</option>
                                <option value="gal">gal - Oromo</option>
                                <option value="gay">gay - Gayo</option>
                                <option value="gba">gba - Gbaya</option>
                                <option value="gem">gem - Germanic (Other)</option>
                                <option value="geo">geo - Georgian</option>
                                <option value="ger">ger - German</option>
                                <option value="gez">gez - Ethiopic</option>
                                <option value="gil">gil - Gilbertese</option>
                                <option value="gla">gla - Scottish Gaelic</option>
                                <option value="gle">gle - Irish</option>
                                <option value="glg">glg - Galician</option>
                                <option value="glv">glv - Manx</option>
                                <option value="gmh">gmh - German, Middle High (ca. 10501500)</option>
                                <option value="goh">goh - German, Old High (ca. 7501050)</option>
                                <option value="gon">gon - Gondi</option>
                                <option value="gor">gor - Gorontalo</option>
                                <option value="got">got - Gothic</option>
                                <option value="grb">grb - Grebo</option>
                                <option value="grc">grc - Greek, Ancient (to 1453)</option>
                                <option value="gre">gre - Greek, Modern (1453)</option>
                                <option value="grn">grn - Guarani</option>
                                <option value="gsw">gsw - Swiss German</option>
                                <option value="gua">gua - Guarani</option>
                                <option value="guj">guj - Gujarati</option>
                                <option value="gwi">gwi - Gwich'in</option>
                                <option value="hai">hai - Haida</option>
                                <option value="hat">hat - Haitian French Creole</option>
                                <option value="hau">hau - Hausa</option>
                                <option value="haw">haw - Hawaiian</option>
                                <option value="heb">heb - Hebrew</option>
                                <option value="her">her - Herero</option>
                                <option value="hil">hil - Hiligaynon</option>
                                <option value="him">him - Western Pahari languages</option>
                                <option value="hin">hin - Hindi</option>
                                <option value="hit">hit - Hittite</option>
                                <option value="hmn">hmn - Hmong</option>
                                <option value="hmo">hmo - Hiri Motu</option>
                                <option value="hrv">hrv - Croatian</option>
                                <option value="hsb">hsb - Upper Sorbian</option>
                                <option value="hun">hun - Hungarian</option>
                                <option value="hup">hup - Hupa</option>
                                <option value="iba">iba - Iban</option>
                                <option value="ibo">ibo - Igbo</option>
                                <option value="ice">ice - Icelandic</option>
                                <option value="ido">ido - Ido</option>
                                <option value="iii">iii - Sichuan Yi</option>
                                <option value="ijo">ijo - Ijo</option>
                                <option value="iku">iku - Inuktitut</option>
                                <option value="ile">ile - Interlingue</option>
                                <option value="ilo">ilo - Iloko</option>
                                <option value="ina">ina - Interlingua (International Auxiliary Language Association)</option>
                                <option value="inc">inc - Indic (Other)</option>
                                <option value="ind">ind - Indonesian</option>
                                <option value="ine">ine - IndoEuropean (Other)</option>
                                <option value="inh">inh - Ingush</option>
                                <option value="int">int - Interlingua (International Auxiliary Language Association)</option>
                                <option value="ipk">ipk - Inupiaq</option>
                                <option value="ira">ira - Iranian (Other)</option>
                                <option value="iri">iri - Irish</option>
                                <option value="iro">iro - Iroquoian (Other)</option>
                                <option value="ita">ita - Italian</option>
                                <option value="jav">jav - Javanese</option>
                                <option value="jbo">jbo - Lojban (Artificial language)</option>
                                <option value="jpn">jpn - Japanese</option>
                                <option value="jpr">jpr - JudeoPersian</option>
                                <option value="jrb">jrb - JudeoArabic</option>
                                <option value="kaa">kaa - KaraKalpak</option>
                                <option value="kab">kab - Kabyle</option>
                                <option value="kac">kac - Kachin</option>
                                <option value="kal">kal - Kalâtdlisut</option>
                                <option value="kam">kam - Kamba</option>
                                <option value="kan">kan - Kannada</option>
                                <option value="kar">kar - Karen languages</option>
                                <option value="kas">kas - Kashmiri</option>
                                <option value="kau">kau - Kanuri</option>
                                <option value="kaw">kaw - Kawi</option>
                                <option value="kaz">kaz - Kazakh</option>
                                <option value="kbd">kbd - Kabardian</option>
                                <option value="kha">kha - Khasi</option>
                                <option value="khi">khi - Khoisan (Other)</option>
                                <option value="khm">khm - Khmer</option>
                                <option value="kho">kho - Khotanese</option>
                                <option value="kik">kik - Kikuyu</option>
                                <option value="kin">kin - Kinyarwanda</option>
                                <option value="kir">kir - Kyrgyz</option>
                                <option value="kmb">kmb - Kimbundu</option>
                                <option value="kok">kok - Konkani</option>
                                <option value="kom">kom - Komi</option>
                                <option value="kon">kon - Kongo</option>
                                <option value="kor">kor - Korean</option>
                                <option value="kos">kos - Kosraean</option>
                                <option value="kpe">kpe - Kpelle</option>
                                <option value="krc">krc - KarachayBalkar</option>
                                <option value="krl">krl - Karelian</option>
                                <option value="kro">kro - Kru (Other)</option>
                                <option value="kru">kru - Kurukh</option>
                                <option value="kua">kua - Kuanyama</option>
                                <option value="kum">kum - Kumyk</option>
                                <option value="kur">kur - Kurdish</option>
                                <option value="kus">kus - Kusaie</option>
                                <option value="kut">kut - Kootenai</option>
                                <option value="lad">lad - Ladino</option>
                                <option value="lah">lah - Lahndā</option>
                                <option value="lam">lam - Lamba (Zambia and Congo)</option>
                                <option value="lan">lan - Occitan (post 1500)</option>
                                <option value="lao">lao - Lao</option>
                                <option value="lap">lap - Sami</option>
                                <option value="lat">lat - Latin</option>
                                <option value="lav">lav - Latvian</option>
                                <option value="lez">lez - Lezgian</option>
                                <option value="lim">lim - Limburgish</option>
                                <option value="lin">lin - Lingala</option>
                                <option value="lit">lit - Lithuanian</option>
                                <option value="lol">lol - MongoNkundu</option>
                                <option value="loz">loz - Lozi</option>
                                <option value="ltz">ltz - Luxembourgish</option>
                                <option value="lua">lua - LubaLulua</option>
                                <option value="lub">lub - LubaKatanga</option>
                                <option value="lug">lug - Ganda</option>
                                <option value="lui">lui - Luiseño</option>
                                <option value="lun">lun - Lunda</option>
                                <option value="luo">luo - Luo (Kenya and Tanzania)</option>
                                <option value="lus">lus - Lushai</option>
                                <option value="mac">mac - Macedonian</option>
                                <option value="mad">mad - Madurese</option>
                                <option value="mag">mag - Magahi</option>
                                <option value="mah">mah - Marshallese</option>
                                <option value="mai">mai - Maithili</option>
                                <option value="mak">mak - Makasar</option>
                                <option value="mal">mal - Malayalam</option>
                                <option value="man">man - Mandingo</option>
                                <option value="mao">mao - Maori</option>
                                <option value="map">map - Austronesian (Other)</option>
                                <option value="mar">mar - Marathi</option>
                                <option value="mas">mas - Maasai</option>
                                <option value="max">max - Manx</option>
                                <option value="may">may - Malay</option>
                                <option value="mdf">mdf - Moksha</option>
                                <option value="mdr">mdr - Mandar</option>
                                <option value="men">men - Mende</option>
                                <option value="mga">mga - Irish, Middle (ca. 11001550)</option>
                                <option value="mic">mic - Micmac</option>
                                <option value="min">min - Minangkabau</option>
                                <option value="mis">mis - Miscellaneous languages</option>
                                <option value="mkh">mkh - MonKhmer (Other)</option>
                                <option value="mla">mla - Malagasy</option>
                                <option value="mlg">mlg - Malagasy</option>
                                <option value="mlt">mlt - Maltese</option>
                                <option value="mnc">mnc - Manchu</option>
                                <option value="mni">mni - Manipuri</option>
                                <option value="mno">mno - Manobo languages</option>
                                <option value="moh">moh - Mohawk</option>
                                <option value="mol">mol - Moldavian</option>
                                <option value="mon">mon - Mongolian</option>
                                <option value="mos">mos - Mooré</option>
                                <option value="mul">mul - Multiple languages</option>
                                <option value="mun">mun - Munda (Other)</option>
                                <option value="mus">mus - Creek</option>
                                <option value="mwl">mwl - Mirandese</option>
                                <option value="mwr">mwr - Marwari</option>
                                <option value="myn">myn - Mayan languages</option>
                                <option value="myv">myv - Erzya</option>
                                <option value="nah">nah - Nahuatl</option>
                                <option value="nai">nai - North American Indian (Other)</option>
                                <option value="nap">nap - Neapolitan Italian</option>
                                <option value="nau">nau - Nauru</option>
                                <option value="nav">nav - Navajo</option>
                                <option value="nbl">nbl - Ndebele (South Africa)</option>
                                <option value="nde">nde - Ndebele (Zimbabwe)</option>
                                <option value="ndo">ndo - Ndonga</option>
                                <option value="nds">nds - Low German</option>
                                <option value="nep">nep - Nepali</option>
                                <option value="new">new - Newari</option>
                                <option value="nia">nia - Nias</option>
                                <option value="nic">nic - NigerKordofanian (Other)</option>
                                <option value="niu">niu - Niuean</option>
                                <option value="nno">nno - Norwegian (Nynorsk)</option>
                                <option value="nob">nob - Norwegian (Bokmål)</option>
                                <option value="nog">nog - Nogai</option>
                                <option value="non">non - Old Norse</option>
                                <option value="nor">nor - Norwegian</option>
                                <option value="nqo">nqo - N'Ko</option>
                                <option value="nso">nso - Northern Sotho</option>
                                <option value="nub">nub - Nubian languages</option>
                                <option value="nwc">nwc - Newari, Old</option>
                                <option value="nya">nya - Nyanja</option>
                                <option value="nym">nym - Nyamwezi</option>
                                <option value="nyn">nyn - Nyankole</option>
                                <option value="nyo">nyo - Nyoro</option>
                                <option value="nzi">nzi - Nzima</option>
                                <option value="oci">oci - Occitan (post1500)</option>
                                <option value="oji">oji - Ojibwa</option>
                                <option value="ori">ori - Oriya</option>
                                <option value="orm">orm - Oromo</option>
                                <option value="osa">osa - Osage</option>
                                <option value="oss">oss - Ossetic</option>
                                <option value="ota">ota - Turkish, Ottoman</option>
                                <option value="oto">oto - Otomian languages</option>
                                <option value="paa">paa - Papuan (Other)</option>
                                <option value="pag">pag - Pangasinan</option>
                                <option value="pal">pal - Pahlavi</option>
                                <option value="pam">pam - Pampanga</option>
                                <option value="pan">pan - Panjabi</option>
                                <option value="pap">pap - Papiamento</option>
                                <option value="pau">pau - Palauan</option>
                                <option value="peo">peo - Old Persian (ca. 600400 B.C.)</option>
                                <option value="per">per - Persian</option>
                                <option value="phi">phi - Philippine (Other)</option>
                                <option value="phn">phn - Phoenician</option>
                                <option value="pli">pli - Pali</option>
                                <option value="pol">pol - Polish</option>
                                <option value="pon">pon - Pohnpeian</option>
                                <option value="por">por - Portuguese</option>
                                <option value="pra">pra - Prakrit languages</option>
                                <option value="pro">pro - Provençal (to 1500)</option>
                                <option value="pus">pus - Pushto</option>
                                <option value="que">que - Quechua</option>
                                <option value="raj">raj - Rajasthani</option>
                                <option value="rap">rap - Rapanui</option>
                                <option value="rar">rar - Rarotongan</option>
                                <option value="roa">roa - Romance (Other)</option>
                                <option value="roh">roh - RaetoRomance</option>
                                <option value="rom">rom - Romani</option>
                                <option value="rum">rum - Romanian</option>
                                <option value="run">run - Rundi</option>
                                <option value="rup">rup - Aromanian</option>
                                <option value="rus">rus - Russian</option>
                                <option value="sad">sad - Sandawe</option>
                                <option value="sag">sag - Sango (Ubangi Creole)</option>
                                <option value="sah">sah - Yakut</option>
                                <option value="sai">sai - South American Indian (Other)</option>
                                <option value="sal">sal - Salishan languages</option>
                                <option value="sam">sam - Samaritan Aramaic</option>
                                <option value="san">san - Sanskrit</option>
                                <option value="sao">sao - Samoan</option>
                                <option value="sas">sas - Sasak</option>
                                <option value="sat">sat - Santali</option>
                                <option value="scc">scc - Serbian</option>
                                <option value="scn">scn - Sicilian Italian</option>
                                <option value="sco">sco - Scots</option>
                                <option value="scr">scr - Croatian</option>
                                <option value="sel">sel - Selkup</option>
                                <option value="sem">sem - Semitic (Other)</option>
                                <option value="sga">sga - Irish, Old (to 1100)</option>
                                <option value="sgn">sgn - Sign languages</option>
                                <option value="shn">shn - Shan</option>
                                <option value="sho">sho - Shona</option>
                                <option value="sid">sid - Sidamo</option>
                                <option value="sin">sin - Sinhalese</option>
                                <option value="sio">sio - Siouan (Other)</option>
                                <option value="sit">sit - SinoTibetan (Other)</option>
                                <option value="sla">sla - Slavic (Other)</option>
                                <option value="slo">slo - Slovak</option>
                                <option value="slv">slv - Slovenian</option>
                                <option value="sma">sma - Southern Sami</option>
                                <option value="sme">sme - Northern Sami</option>
                                <option value="smi">smi - Sami</option>
                                <option value="smj">smj - Lule Sami</option>
                                <option value="smn">smn - Inari Sami</option>
                                <option value="smo">smo - Samoan</option>
                                <option value="sms">sms - Skolt Sami</option>
                                <option value="sna">sna - Shona</option>
                                <option value="snd">snd - Sindhi</option>
                                <option value="snh">snh - Sinhalese</option>
                                <option value="snk">snk - Soninke</option>
                                <option value="sog">sog - Sogdian</option>
                                <option value="som">som - Somali</option>
                                <option value="son">son - Songhai</option>
                                <option value="sot">sot - Sotho</option>
                                <option value="spa">spa - Spanish</option>
                                <option value="srd">srd - Sardinian</option>
                                <option value="srn">srn - Sranan</option>
                                <option value="srp">srp - Serbian</option>
                                <option value="srr">srr - Serer</option>
                                <option value="ssa">ssa - NiloSaharan (Other)</option>
                                <option value="sso">sso - Sotho</option>
                                <option value="ssw">ssw - Swazi</option>
                                <option value="suk">suk - Sukuma</option>
                                <option value="sun">sun - Sundanese</option>
                                <option value="sus">sus - Susu</option>
                                <option value="sux">sux - Sumerian</option>
                                <option value="swa">swa - Swahili</option>
                                <option value="swe">swe - Swedish</option>
                                <option value="swz">swz - Swazi</option>
                                <option value="syc">syc - Syriac</option>
                                <option value="syr">syr - Syriac, Modern</option>
                                <option value="tag">tag - Tagalog</option>
                                <option value="tah">tah - Tahitian</option>
                                <option value="tai">tai - Tai (Other)</option>
                                <option value="taj">taj - Tajik</option>
                                <option value="tam">tam - Tamil</option>
                                <option value="tar">tar - Tatar</option>
                                <option value="tat">tat - Tatar</option>
                                <option value="tel">tel - Telugu</option>
                                <option value="tem">tem - Temne</option>
                                <option value="ter">ter - Terena</option>
                                <option value="tet">tet - Tetum</option>
                                <option value="tgk">tgk - Tajik</option>
                                <option value="tgl">tgl - Tagalog</option>
                                <option value="tha">tha - Thai</option>
                                <option value="tib">tib - Tibetan</option>
                                <option value="tig">tig - Tigré</option>
                                <option value="tir">tir - Tigrinya</option>
                                <option value="tiv">tiv - Tiv</option>
                                <option value="tkl">tkl - Tokelauan</option>
                                <option value="tlh">tlh - Klingon (Artificial language)</option>
                                <option value="tli">tli - Tlingit</option>
                                <option value="tmh">tmh - Tamashek</option>
                                <option value="tog">tog - Tonga (Nyasa)</option>
                                <option value="ton">ton - Tongan</option>
                                <option value="tpi">tpi - Tok Pisin</option>
                                <option value="tru">tru - Truk</option>
                                <option value="tsi">tsi - Tsimshian</option>
                                <option value="tsn">tsn - Tswana</option>
                                <option value="tso">tso - Tsonga</option>
                                <option value="tsw">tsw - Tswana</option>
                                <option value="tuk">tuk - Turkmen</option>
                                <option value="tum">tum - Tumbuka</option>
                                <option value="tup">tup - Tupi languages</option>
                                <option value="tur">tur - Turkish</option>
                                <option value="tut">tut - Altaic (Other)</option>
                                <option value="tvl">tvl - Tuvaluan</option>
                                <option value="twi">twi - Twi</option>
                                <option value="tyv">tyv - Tuvinian</option>
                                <option value="udm">udm - Udmurt</option>
                                <option value="uga">uga - Ugaritic</option>
                                <option value="uig">uig - Uighur</option>
                                <option value="ukr">ukr - Ukrainian</option>
                                <option value="umb">umb - Umbundu</option>
                                <option value="und">und - Undetermined</option>
                                <option value="urd">urd - Urdu</option>
                                <option value="uzb">uzb - Uzbek</option>
                                <option value="vai">vai - Vai</option>
                                <option value="ven">ven - Venda</option>
                                <option value="vie">vie - Vietnamese</option>
                                <option value="vol">vol - Volapük</option>
                                <option value="vot">vot - Votic</option>
                                <option value="wak">wak - Wakashan languages</option>
                                <option value="wal">wal - Wolayta</option>
                                <option value="war">war - Waray</option>
                                <option value="was">was - Washoe</option>
                                <option value="wel">wel - Welsh</option>
                                <option value="wen">wen - Sorbian (Other)</option>
                                <option value="wln">wln - Walloon</option>
                                <option value="wol">wol - Wolof</option>
                                <option value="xal">xal - Oirat</option>
                                <option value="xho">xho - Xhosa</option>
                                <option value="yao">yao - Yao (Africa)</option>
                                <option value="yap">yap - Yapese</option>
                                <option value="yid">yid - Yiddish</option>
                                <option value="yor">yor - Yoruba</option>
                                <option value="ypk">ypk - Yupik languages</option>
                                <option value="zap">zap - Zapotec</option>
                                <option value="zbl">zbl - Blissymbolics</option>
                                <option value="zen">zen - Zenaga</option>
                                <option value="zha">zha - Zhuang</option>
                                <option value="znd">znd - Zande languages</option>
                                <option value="zul">zul - Zulu</option>
                                <option value="zun">zun - Zuni</option>
                                <option value="zxx">zxx - No linguistic content</option>
                                <option value="zza">zza - Zaza</option>                                
                            </select>
                            <br/>
                            <label for="p38">38 - Modified record</label>
                            <select class="form-select" aria-label="Modified record" id="p38" v-model="record.f008.p38">
                                <option value="#"># - Not modified</option>
                                <option value="d">d - Dashed-on information omitted</option>
                                <option value="o">o - Completely romanized/printed cards romanized</option>
                                <option value="r">r - Completely romanized/printed cards in script</option>
                                <option value="s">s - Shortened</option>
                                <option value="x">x - Missing characters</option>
                                <option value="|">| - No attempt to code</option>
                            </select>

                            <label for="p39">39 - Cataloging source</label>
                            <select class="form-select" aria-label="Cataloging source" id="p39" v-model="record.f008.p39">
                                <option value="#"># - National bibliographic agency</option>
                                <option value="c">c - Cooperative cataloging program</option>
                                <option value="d">d - Other</option>
                                <option value="u">u - Unknown</option>
                                <option value="|">| - No attempt to code</option>
                            </select>

                        </div>
                        <!-- /008 -->

                        <!-- ISBN -->
                        <div v-show="isbnShow" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="alert alert-warning" role="alert" v-show="loadingISBN">Searching in Google Books ...</div>
                            <div class="alert alert-warning" role="alert" v-show="loadingZ3950">Searching Z39.50 servers ...</div>
                            <button @click="addField('isbn')" class="btn btn-info btn-sm mb-2">Add ISBN</button>

                            <div class="input-group mb-2" v-for="(isbn, indexisbn) in record.isbn">
                                <div class="input-group-prepend"><span class="input-group-text">ISBN&nbsp;&nbsp;
                                    <a href="https://www.loc.gov/marc/bibliographic/bd020.html" rel="external" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    </a>
                                </span></div>
                                <input type="text" class="form-control" v-model.trim="isbn.id" id="isbn" name="isbn" placeholder="Enter ISBN">
                                <button class="btn btn-info" @click="getISBNGoogleBooks(record.isbn[indexisbn].id), loadingISBN = true">Google Books</button>
                                <button class="btn btn-info" @click="
                                    getZ3950(record.isbn[indexisbn].id, 'dedalus.usp.br:9991/usp01', 'USP/DEDALUS'),
                                    getZ3950(record.isbn[indexisbn].id, 'unesp.alma.exlibrisgroup.com:1921/55UNESP_INST', 'UNESP'),
                                    getZ3950(record.isbn[indexisbn].id, '162.214.168.248:9998/bib', 'BN'),
                                    getZ3950(record.isbn[indexisbn].id, 'z3950.loc.gov:7090/Voyager', 'Library of Congress'),
                                    loadingZ3950 = true
                                ">Z39.50</button>
                                <button @click="deleteField('isbn', indexisbn)" class="btn btn-danger btn-sm">Apagar</button>
                            </div>

                            <div class="alert alert-info alert-dismissible fade show bg-opacity-10" role="alert" v-show="Z3950Records">
                                <table class="table p-2 text-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col">Source</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Authors</th>
                                            <th scope="col">Others authors</th>
                                            <th scope="col">Publisher</th>
                                            <th scope="col">Place</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Physical description</th>
                                            <th scope="col">Language</th>
                                            <th scope="col">Edition</th>
                                            <th scope="col">Use</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(Z3950Record, indexZ3950Record) in Z3950Records" :key="indexZ3950Record">
                                            <th scope="row">{{ Z3950Record.source }}</th>
                                            <td>{{ Z3950Record.title }}</td>
                                            <td>{{ Z3950Record.author }}</td>
                                            <td>{{ Z3950Record.editor }}</td>
                                            <td>{{ Z3950Record.publisher }}</td>
                                            <td>{{ Z3950Record.pub_place }}</td>
                                            <td>{{ Z3950Record.pub_date }}</td>
                                            <td>{{ Z3950Record.extent }}</td>
                                            <td>{{ Z3950Record.language }}</td>
                                            <td>{{ Z3950Record.edition }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm m-2" @click="
                                                    record.title = Z3950Record.title,
                                                    record.subtitle = Z3950Record.subtitle,
                                                    record._260c = Z3950Record.pub_date,
                                                    record._260b = Z3950Record.publisher,
                                                    record._300a = Z3950Record.extent
                                                    record.f008.p35_37 = Z3950Record.language
                                                ">Use</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn-close" aria-label="Close" @click="Z3950Records = null"></button>
                            </div>

                        </div>
                        <!-- /ISBN -->

                        <!-- DOI -->
                        <div v-show="doiShow" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="alert alert-warning" role="alert" v-if="loadingDOI">
                                Getting DOI data from CrossRef ...
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend"><span class="input-group-text">DOI&nbsp;&nbsp;
                                    <a href="https://www.loc.gov/marc/bibliographic/bd024.html" rel="external" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </a>
                                </span></div>
                                <input type="text" class="form-control" v-model="record.doi" id="doi" name="doi" placeholder="DOI">
                                <button class="btn btn-info btn-sm" @click="getDOI(record.doi), loadingDOI = true">Retrieve DOI metadata from CrossRef</button>
                            </div>
                        </div>
                        <!-- /DOI -->
                        <!-- LDR -->
                        <div v-show="ldrShow" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <label for="record_status">05 - Record status</label>
                            <select class="form-select" aria-label="Record status" id="record_status" v-model="record.ldr.record_status">
                                <option value="a">a - Increase in encoding level</option>
                                <option value="c">c - Corrected or revised</option>
                                <option value="d">d - Deleted</option>
                                <option value="n">n - New</option>
                                <option value="p">p - Increase in encoding level from prepublication</option>
                            </select>
                            <label for="type_of_record">06 - Type of record</label>
                            <select class="form-select" aria-label="Type of record" id="type_of_record" v-model="record.ldr.type_of_record">
                                <option value="a">a - Language material</option>
                                <option value="c">c - Notated music</option>
                                <option value="d">d - Manuscript notated music</option>
                                <option value="e">e - Cartographic material</option>
                                <option value="f">f - Manuscript cartographic material</option>
                                <option value="g">g - Projected medium</option>
                                <option value="i">i - Nonmusical sound recording</option>
                                <option value="j">j - Musical sound recording</option>
                                <option value="k">k - Two-dimensional nonprojectable graphic</option>
                                <option value="m">m - Computer file</option>
                                <option value="o">o - Kit</option>
                                <option value="p">p - Mixed materials</option>
                                <option value="r">r - Three-dimensional artifact or naturally occurring object</option>
                                <option value="t">t - Manuscript language material</option>
                            </select>
                            <label for="bibliographic_level">07 - Bibliographic level</label>
                            <select class="form-select" aria-label="Bibliographic level" id="bibliographic_level" v-model="record.ldr.bibliographic_level">
                                <option value="a">a - Monographic component part</option>
                                <option value="b">b - Serial component part</option>
                                <option value="c">c - Collection</option>
                                <option value="d">d - Subunit</option>
                                <option value="i">i - Integrating resource</option>
                                <option value="m">m - Monograph/Item</option>
                                <option value="s">s - Serial</option>
                            </select>
                            <label for="type_of_control">08 - Type of control</label>
                            <select class="form-select" aria-label="Type of control" id="type_of_control" v-model="record.ldr.type_of_control">
                                <option value="#"># - No specified type</option>
                                <option value="a">a - Archival</option>
                            </select>
                            <label for="character_coding_scheme">09 - Character coding scheme</label>
                            <select class="form-select" aria-label="Character coding scheme" id="character_coding_scheme" v-model="record.ldr.character_coding_scheme">
                                <option value="#"># - MARC-8</option>
                                <option value="a">a - UCS/Unicode</option>
                            </select>
                            <!-- <div class="mb-3">
                                <label for="base_address_of_data" class="form-label">Base address of data (Length of Leader and Directory)</label>
                                <input v-model="base_address_of_data" type="text" class="form-control" id="base_address_of_data">
                            </div> -->
                            <label for="encoding_level">17 - Encoding level</label>
                            <select class="form-select" aria-label="Encoding level" id="encoding_level" v-model="record.ldr.encoding_level">
                                <option value="#"># - Full level</option>
                                <option value="1">1 - Full level, material not examined</option>
                                <option value="2">2 - Less-than-full level, material not examined</option>
                                <option value="3">3 - Abbreviated level</option>
                                <option value="4">4 - Core level</option>
                                <option value="5">5 - Partial (preliminary) level</option>
                                <option value="7">7 - Minimal level</option>
                                <option value="8">8 - Prepublication level</option>
                                <option value="u">u - Unknown</option>
                                <option value="u">u - Unknown</option>
                                <option value="z">z - Not applicable</option>
                                <option value="I">I - Full level cataloging input by OCLC participating library</option>
                                <option value="K">K - Less-than-full cataloging input by OCLC participating library</option>
                                <option value="L">L - Non-LC and non-NLM cataloging added from tape</option>
                                <option value="M">M - Less-than-full cataloging added from tapeloading</option>
                            </select>
                            <label for="descriptive_cataloging_form">18 - Descriptive cataloging form</label>
                            <select class="form-select" aria-label="Descriptive cataloging form" id="descriptive_cataloging_form" v-model="record.ldr.descriptive_cataloging_form">
                                <option value="#"># - Non-ISBD</option>
                                <option value="a">a - AACR 2</option>
                                <option value="c">c - ISBD punctuation omitted</option>
                                <option value="i">i - ISBD punctuation included</option>
                                <option value="n">n - Non-ISBD punctuation omitted</option>
                                <option value="u">u - Unknown</option>
                            </select>
                            <label for="multipart_resource_record_level">19 - Multipart resource record level</label>
                            <select class="form-select" aria-label="Multipart resource record level" id="multipart_resource_record_level" v-model="record.ldr.multipart_resource_record_level">
                                <option value="#"># - Not specified or not applicable</option>
                                <option value="a">a - Set</option>
                                <option value="b">b - Part with independent title</option>
                                <option value="c">c - Part with dependent title</option>
                            </select>
                            <button type="button" class="btn-close" v-on:click="ldrShow = !ldrShow" aria-label="Close"></button>
                        </div>
                        <!-- /LDR -->

                        <!-- 001 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="_001">{{ translation.control_number }}&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd001.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <input type="text" id="_001" v-model="record._001" class="form-control" :placeholder="translation.control_number" :aria-label="translation.control_number" aria-describedby="_001">
                        </div>
                        <!-- \001 -->

                        <!-- 003 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="_003">{{ translation.control_number_identifier }}&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd003.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <input type="text" id="_003" v-model="record._003" class="form-control" :placeholder="translation.control_number_identifier" :aria-label="translation.control_number_identifier" aria-describedby="_003">
                        </div>
                        <!-- \003 -->

                        <!-- 040 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="_040">{{ translation.cataloging_source }}&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd040.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <input type="text" id="_040a" v-model="record._040a" class="form-control" :placeholder="translation._040a" :aria-label="translation._040a" aria-describedby="_040a">
                            <input type="text" id="_040c" v-model="record._040c" class="form-control" :placeholder="translation._040c" :aria-label="translation._040c" aria-describedby="_040c">
                        </div>
                        <!-- \040 -->

                        <!-- 100 -->
                        <template>
                            <div class="row mb-2" v-for="(author, indexAuthor) in record.personal_name">
                                <div class='col-2'>
                                    <span class="input-group-text" id="personal_name">Personal Name&nbsp;&nbsp;
                                        <a href="https://www.loc.gov/marc/bibliographic/bd100.html" rel="external" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg>
                                        </a>
                                    </span>
                                </div>
                                <div class="col-9">
                                    <div class="input-group-prepend">
                                        <select class="input-group-text form-select" id="_100_ind1" v-model="record.personal_name[indexAuthor].ind1">
                                            <option disabled>Type of personal name entry element</option>
                                            <option value="0">0 - Forename</option>
                                            <option value="1">1 - Surname</option>
                                            <option value="3">3 - Family name</option>
                                        </select>
                                    </div>                                
                                    <input type="text" id="_100a" v-model="record.personal_name[indexAuthor].a" class="form-control" placeholder="Personal name" aria-label="Personal name" aria-describedby="_100a">
                                    <input type="text" id="_100d" v-model="record.personal_name[indexAuthor].d" class="form-control" placeholder="Dates associated with a name" aria-label="Dates associated with a name" aria-describedby="_100d">
                                    <input type="text" id="_100e" v-model="record.personal_name[indexAuthor].e" class="form-control" placeholder="Relator term" aria-label="Relator term" aria-describedby="_100e">                                    
                                    <input type="text" id="_100q" v-model="record.personal_name[indexAuthor].q" class="form-control" placeholder="Fuller form of name" aria-label="Fuller form of name" aria-describedby="_100q">
                                    <input type="text" id="_100u" v-model="record.personal_name[indexAuthor].u" class="form-control" placeholder="Affiliation" aria-label="Affiliation" aria-describedby="_100u">
                                </div>
                                <div class="col-1">
                                    <button @click="deleteField('personal_name', indexAuthor)" class="btn btn-danger btn-sm">Delete</button>
                                </div>
                            </div>

                            <button @click="addField('personal_name')" class="btn btn-info btn-sm mb-2">
                            {{ translation.add_personal_name }}
                            </button>
                        </template>
                        <!-- \100 -->

                        <!-- 110 -->
                        <template>
                            <div class="input-group mb-2" v-for="(corporate, indexCorporate) in record.corporate_name">

                                <span class="input-group-text" id="corporate_name">Corporate Name&nbsp;&nbsp;
                                    <a href="https://www.loc.gov/marc/bibliographic/bd110.html" rel="external" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    </a>
                                </span>
                                <div class="input-group-prepend">
                                    <select class="input-group-text form-select" id="_110_ind1" v-model="record.corporate_name[indexCorporate].ind1">
                                        <option disabled>Type of corporate name entry element</option>
                                        <option value="0">0 - Inverted name</option>
                                        <option value="1">1 - Jurisdiction name</option>
                                        <option value="2">2 - Name in direct order</option>
                                    </select>
                                </div>
                                <input type="text" id="_100a" v-model="record.corporate_name[indexCorporate].a" class="form-control" placeholder="Corporate name or jurisdiction name as entry element" aria-label="Corporate name or jurisdiction name as entry element" aria-describedby="_100a">
                                <button @click="deleteField('corporate_name', indexCorporate)" class="btn btn-danger btn-sm">Delete</button>
                            </div>

                            <button @click="addField('corporate_name')" class="btn btn-info btn-sm mb-2">
                            Add Corporate Name
                            </button>
                        </template>
                        <!-- \110 -->


                        <!-- TITLE -->
                        <div class="row mb-3">
                            <div class="col-2">
                                <span class="input-group-text" id="title">Title statement&nbsp;&nbsp;
                                    <a href="https://www.loc.gov/marc/bibliographic/bd245.html" rel="external" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    </a>
                                </span>
                            </div>
                            <div class="col-10">
                            <div class="input-group-prepend">
                                <select class="input-group-text form-select" id="_245_ind1" v-model="record._245_ind1">
                                    <option disabled>Title added entry</option>
                                    <option value="0">No added entry</option>
                                    <option value="1">Added entry</option>
                                </select>
                            </div>
                            <div class="input-group-prepend">
                                <select class="input-group-text form-select" id="_245_ind2" v-model="record._245_ind2">
                                    <option disabled>Nonfiling characters</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="title">Title</span>
                                <input type="text" id="title" v-model="record.title" class="form-control" :class="validation._245a" placeholder="Title" aria-label="Title" aria-describedby="title">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="subtitle">Subtitle</span>
                                <input type="text" id="subtitle" v-model="record.subtitle" class="form-control" placeholder="Subtitle statement" aria-label="Subtitle statement" aria-describedby="subtitle">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="245c">Statement of responsibility, etc.</span>
                                <input type="text" id="245c" v-model="record._245c" class="form-control" placeholder="Statement of responsibility, etc." aria-label="Statement of responsibility, etc." aria-describedby="245c">
                            </div>
                            
                            
                            </div>
                        </div>
                        <!-- \TITLE -->
                        <!-- SUBTITLE -->

                        <!-- \SUBTITLE -->
                        <!-- 245c -->

                        <!-- \245c -->

                        <!-- 260 -->
                        <div class="input-group mb-3 col">
                            <span class="input-group-text col-md-1" id="title">Imprint&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd260.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <div class="input-group-prepend col-md-2">
                                <select class="input-group-text form-select" id="_260_ind1" v-model="record._260_ind1">
                                    <option disabled>Sequence of publishing statements</option>
                                    <option value="#"># - Not applicable/No information provided/Earliest available publisher</option>
                                    <option value="2">2 - Intervening publisher</option>
                                    <option value="3">3 - Current/latest publisher</option>
                                </select>
                            </div>
                            <input type="text" id="_260a" v-model="record._260a" class="form-control col-md-3" placeholder="Place of publication" aria-label="Place of publication" aria-describedby="_260a">
                            <input type="text" id="_260b" v-model="record._260b" class="form-control col-md-3" placeholder="Name of publisher" aria-label="Name of publisher" aria-describedby="_260b">
                            <input type="text" id="_260c" v-model="record._260c" class="form-control col-md-3" placeholder="Date of publication" aria-label="Date of publication" aria-describedby="_260c">
                        </div>
                        <!-- \260 -->

                        <!-- 300 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="_300">Physical Description&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd300.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <input type="text" id="_300a" v-model="record._300a" class="form-control" placeholder="Extent" aria-label="Extent" aria-describedby="_300a">
                            <input type="text" id="_300b" v-model="record._300b" class="form-control" placeholder="Other physical details" aria-label="Other physical details" aria-describedby="_300b">
                            <input type="text" id="_300c" v-model="record._300c" class="form-control" placeholder="Dimensions" aria-label="Dimensions" aria-describedby="_300c">
                        </div>
                        <!-- \300 -->

                        <!-- 310 -->
                        <div class="input-group mb-3" v-if="recordType === 'Serial'">
                            <span class="input-group-text" id="_310">Current Publication Frequency&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd310.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <input type="text" id="_310a" v-model="record._310a" class="form-control" placeholder="Current publication frequency" aria-label="Current publication frequency" aria-describedby="_310a">
                        </div>
                        <!-- \310 -->

                        <div v-if="RDA === true">

                            <!-- 336 -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="_336">336 - Content Type&nbsp;&nbsp;
                                    <a href="https://www.loc.gov/marc/bibliographic/bd336.html" rel="external" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    </a>
                                </span>

                                <select class="input-group-text form-select " id="_336a" v-model="record._336a">
                                    <option disabled>RDA content term</option>
                                    <option value="cartographic dataset">cartographic dataset</option>
                                    <option value="cartographic image">cartographic image</option>
                                    <option value="cartographic moving image">cartographic moving image</option>
                                    <option value="cartographic tactile image">cartographic tactile image</option>
                                    <option value="cartographic tactile three-dimensional form">cartographic tactile three-dimensional form</option>
                                    <option value="cartographic three-dimensional form">cartographic three-dimensional form</option>
                                    <option value="computer dataset">computer dataset</option>
                                    <option value="computer program">computer program</option>
                                    <option value="notated movement">notated movement</option>
                                    <option value="notated music">notated music</option>
                                    <option value="performed music">performed music</option>
                                    <option value="sounds">sounds</option>
                                    <option value="spoken word">spoken word</option>
                                    <option value="still image">still image</option>
                                    <option value="tactile image">tactile image</option>
                                    <option value="tactile notated music">tactile notated music</option>
                                    <option value="tactile notated movement">tactile notated movement</option>
                                    <option value="tactile text">tactile text</option>
                                    <option value="tactile three-dimensional form">tactile three-dimensional form</option>
                                    <option value="text">text</option>
                                    <option value="three-dimensional form">three-dimensional form</option>
                                    <option value="three-dimensional moving image">three-dimensional moving image</option>
                                    <option value="two-dimensional moving image">two-dimensional moving image</option>
                                    <option value="other">other</option>
                                    <option value="unspecified">unspecified</option>
                                </select>
                                <input type="text" id="_336b" v-model="_336b" class="form-control" placeholder="Content type code" aria-label="Content type code" aria-describedby="_336b" disabled>
                                <input type="text" id="_3362" v-model="record._3362" class="form-control" placeholder="Source" aria-label="Source" aria-describedby="_3362" disabled>
                            </div>
                            <!-- \336 -->

                            <!-- 337 -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="_337">337 - Media Type&nbsp;&nbsp;
                                    <a href="https://www.loc.gov/marc/bibliographic/bd337.html" rel="external" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    </a>
                                </span>
                                <select class="input-group-text form-select " id="_337a" v-model="record._337a">
                                    <option disabled>RDA media terms</option>
                                    <option value="audio">audio</option>
                                    <option value="computer">computer</option>
                                    <option value="microform">microform</option>
                                    <option value="microscopic">microscopic</option>
                                    <option value="projected">projected</option>
                                    <option value="stereographic">stereographic</option>
                                    <option value="unmediated">unmediated</option>
                                    <option value="video">video</option>
                                    <option value="other">other</option>
                                    <option value="unspecified">unspecified</option>
                                </select>
                                <input type="text" id="_337b" v-model="_337b" class="form-control" placeholder="MARC code for RDA terms" aria-label="MARC code for RDA terms" aria-describedby="_337b" disabled>
                                <input type="text" id="_3372" v-model="record._3372" class="form-control" placeholder="Source" aria-label="Source" aria-describedby="_3372" disabled>
                            </div>
                            <!-- \337 -->

                            <!-- 338 -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="_338">338 - Carrier Type&nbsp;&nbsp;
                                    <a href="https://www.loc.gov/marc/bibliographic/bd338.html" rel="external" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    </a>
                                </span>





                  

                                <select class="input-group-text form-select " id="_338a" v-model="record._338a">
                                    <option disabled>RDA carrier terms</option>                                    
                                    <option value="audio cartridge" v-if="record._337a == 'audio'">audio cartridge</option>
                                    <option value="audio belt" v-if="record._337a == 'audio'">audio belt</option>
                                    <option value="audio cylinder" v-if="record._337a == 'audio'">audio cylinder</option>
                                    <option value="audio disc" v-if="record._337a == 'audio'">audio disc</option>
                                    <option value="sound track reel" v-if="record._337a == 'audio'">sound track reel</option>
                                    <option value="audio roll" v-if="record._337a == 'audio'">audio roll</option>
                                    <option value="audio wire reel" v-if="record._337a == 'audio'">audio wire reel</option>
                                    <option value="audiocassette" v-if="record._337a == 'audio'">audiocassette</option>
                                    <option value="audiotape reel" v-if="record._337a == 'audio'">audiotape reel</option>
                                    <option value="other" v-if="record._337a == 'audio'">other</option>
                                    <option value="computer card" v-if="record._337a == 'computer'">computer card</option>
                                    <option value="computer chip cartridge" v-if="record._337a == 'computer'">computer chip cartridge</option>
                                    <option value="computer disc" v-if="record._337a == 'computer'">computer disc</option>
                                    <option value="computer disc cartridge" v-if="record._337a == 'computer'">computer disc cartridge</option>
                                    <option value="computer tape cartridge" v-if="record._337a == 'computer'">computer tape cartridge</option>
                                    <option value="computer tape cassette" v-if="record._337a == 'computer'">computer tape cassette</option>
                                    <option value="computer tape reel" v-if="record._337a == 'computer'">computer tape reel</option>
                                    <option value="online resource" v-if="record._337a == 'computer'">online resource</option>
                                    <option value="other" v-if="record._337a == 'computer'">other</option>
                                    <option value="aperture card" v-if="record._337a == 'microform'">aperture card</option>
                                    <option value="microfiche" v-if="record._337a == 'microform'">microfiche</option>
                                    <option value="microfiche cassette" v-if="record._337a == 'microform'">microfiche cassette</option>
                                    <option value="microfilm cartridge" v-if="record._337a == 'microform'">microfilm cartridge</option>
                                    <option value="microfilm cassette" v-if="record._337a == 'microform'">microfilm cassette</option>
                                    <option value="microfilm reel" v-if="record._337a == 'microform'">microfilm reel</option>
                                    <option value="microfilm roll" v-if="record._337a == 'microform'">microfilm roll</option>
                                    <option value="microfilm slip" v-if="record._337a == 'microform'">microfilm slip</option>
                                    <option value="microopaque" v-if="record._337a == 'microform'">microopaque</option>
                                    <option value="other" v-if="record._337a == 'microform'">other</option>
                                    <option value="microscope slide" v-if="record._337a == 'microscopic'">microscope slide</option>
                                    <option value="other" v-if="record._337a == 'microscopic'">other</option>
                                    <option value="film cartridge" v-if="record._337a == 'projected'">film cartridge</option>
                                    <option value="film cassette" v-if="record._337a == 'projected'">film cassette</option>
                                    <option value="film reel" v-if="record._337a == 'projected'">film reel</option>
                                    <option value="film roll" v-if="record._337a == 'projected'">film roll</option>
                                    <option value="filmslip" v-if="record._337a == 'projected'">filmslip</option>
                                    <option value="filmstrip" v-if="record._337a == 'projected'">filmstrip</option>
                                    <option value="filmstrip cartridge" v-if="record._337a == 'projected'">filmstrip cartridge</option>
                                    <option value="overhead transparency" v-if="record._337a == 'projected'">overhead transparency</option>
                                    <option value="slide" v-if="record._337a == 'projected'">slide</option>
                                    <option value="other" v-if="record._337a == 'projected'">other</option>
                                    <option value="stereograph card" v-if="record._337a == 'stereographic'">stereograph card</option>
                                    <option value="stereograph disc" v-if="record._337a == 'stereographic'">stereograph disc</option>
                                    <option value="other" v-if="record._337a == 'stereographic'">other</option>
                                    <option value="card" v-if="record._337a == 'unmediated'">card</option>
                                    <option value="flipchart" v-if="record._337a == 'unmediated'">flipchart</option>
                                    <option value="roll" v-if="record._337a == 'unmediated'">roll</option>
                                    <option value="sheet" v-if="record._337a == 'unmediated'">sheet</option>
                                    <option value="volume" v-if="record._337a == 'unmediated'">volume</option>
                                    <option value="object" v-if="record._337a == 'unmediated'">object</option>
                                    <option value="other" v-if="record._337a == 'unmediated'">other</option>
                                    <option value="video cartridge" v-if="record._337a == 'video'">video cartridge</option>
                                    <option value="videocassette" v-if="record._337a == 'video'">videocassette</option>
                                    <option value="videodisc" v-if="record._337a == 'video'">videodisc</option>
                                    <option value="videotape reel" v-if="record._337a == 'video'">videotape reel</option>
                                    <option value="other" v-if="record._337a == 'video'">other</option>
                                    <option value="unspecified" v-if="record._337a == 'unspecified'">unspecified</option>
                                </select>
                                <input type="text" id="_338b" v-model="_338b" class="form-control" placeholder="MARC code for RDA terms" aria-label="MARC code for RDA terms" aria-describedby="_338b" disabled>
                                <input type="text" id="_3382" v-model="record._3382" class="form-control" placeholder="Source" aria-label="Source" aria-describedby="_3382" disabled>
                            </div>
                            <!-- \338 -->

                        </div>

                        <!-- 500 -->

                        <div class="input-group mb-2" v-for="(note, indexNote) in record.general_note">
                            <span class="input-group-text" id="general_note">General Note&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd500.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <input type="text" id="_500a" v-model="record.general_note[indexNote].a" class="form-control" placeholder="General Note" aria-label="General Note" aria-describedby="_500a">
                            <button @click="deleteField('general_note', indexNote)" class="btn btn-danger btn-sm">Delete</button>
                        </div>

                        <button @click="addField('general_note')" class="btn btn-info btn-sm mb-2">Add General Note</button>

                        <!-- \500 -->

                        <!-- 650 -->
                        <div class="input-group mb-3 col" v-for="(subjectTT, indexSubjectTT) in record._650">
                            <span class="input-group-text" id="subject_tt">Subject Added Entry-Topical Term&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd650.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <div class="input-group-prepend col-md-1">
                                <select class="input-group-text form-select " id="_650_ind1" v-model="record._650[indexSubjectTT].ind1">
                                    <option disabled>Level of subject</option>
                                    <option value="#"># - No information provided</option>
                                    <option value="0">0 - No level specified</option>
                                    <option value="1">1 - Primary</option>
                                    <option value="2">2 - Secondary</option>
                                </select>
                            </div>
                            <div class="input-group-prepend col-md-1">
                                <select class="input-group-text form-select " id="_650_ind2" v-model="record._650[indexSubjectTT].ind2">
                                    <option disabled>Thesaurus</option>
                                    <option value="0">0 - Library of Congress Subject Headings</option>
                                    <option value="1">1 - LC subject headings for children's literature</option>
                                    <option value="2">2 - Medical Subject Headings</option>
                                    <option value="3">3 - National Agricultural Library subject authority file</option>
                                    <option value="4">4 - Source not specified</option>
                                    <option value="5">5 - Canadian Subject Headings</option>
                                    <option value="6">6 - Répertoire de vedettes-matière</option>
                                    <option value="7">7 - Source specified in subfield $2</option>
                                </select>
                            </div>
                            <input type="text" id="tt" v-model="record._650[indexSubjectTT].a" class="form-control col-md-3" placeholder="Topical term or geographic name entry element" aria-label="Topical term or geographic name entry element" aria-describedby="_650a">
                            <input type="text" id="_6502" v-model="record._650[indexSubjectTT]._2" class="form-control col-md-3" placeholder="Source of heading or term" aria-label="Source of heading or term" aria-describedby="_6502" v-if="record._650[indexSubjectTT].ind2 == '7'">
                            <button @click="deleteField('_650', indexSubjectTT)" class="btn btn-danger btn-sm col-md-1">Delete</button>
                        </div>
                        <button @click="addField('_650')" class="btn btn-info btn-sm mb-2">Add Subject Added Entry-Topical Term</button>
                        <!-- \650 -->

                        <!-- 856 -->
                        <div class="input-group mb-3 col" v-for="(url, indexURL) in record._856">
                            <span class="input-group-text" id="title">Electronic Location and Access&nbsp;&nbsp;
                                <a href="https://www.loc.gov/marc/bibliographic/bd856.html" rel="external" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                </a>
                            </span>
                            <div class="input-group-prepend col-md-1">
                                <select class="input-group-text form-select" id="_856_ind1" v-model="record._856[indexURL].ind1">
                                    <option disabled>Access method</option>
                                    <option value="#"># - No information provided</option>
                                    <option value="0">0 - Email</option>
                                    <option value="1">1 - FTP</option>
                                    <option value="2">2 - Remote login (Telnet)</option>
                                    <option value="3">3 - Dial-up</option>
                                    <option value="4">4 - HTTP</option>
                                    <option value="7">7 - Method specified in subfield $2</option>
                                </select>
                            </div>
                            <div class="input-group-prepend col-md-1">
                                <select class="input-group-text form-select" id="_856_ind2" v-model="record._856[indexURL].ind2">
                                    <option disabled>Relationship</option>
                                    <option value="#"># - No information provided</option>
                                    <option value="0">0 - Resource</option>
                                    <option value="1">1 - Version of resource</option>
                                    <option value="2">2 - Related resource</option>
                                    <option value="8">8 - No display constant generated</option>
                                </select>
                            </div>
                            <input type="text" id="url" v-model="record._856[indexURL].u" class="form-control col-md-6" placeholder="Uniform Resource Identifier" aria-label="Uniform Resource Identifier" aria-describedby="url">
                            <button @click="deleteField('_856', indexURL)" class="btn btn-danger btn-sm col-md-1">Delete</button>
                        </div>
                        <button @click="addField('_856')" class="btn btn-info btn-sm mb-2">Add Electronic Location and Access</button>
                        <!-- \856 -->


          </div>
          <div class="col-md-5 col-lg-4">
            <h2>MARC Record</h2>
            <pre>
                {{ complete_record }}
            </pre>
            <span class="btn btn-info text-white copy-btn ml-auto" @click.stop.prevent="copyTestingCode">Copy</span>
            <input type="hidden" id="complete_record" :value="complete_record">

            <div class="alert alert-info" role="alert" v-if="copySuccessful">
                Copied successful!
            </div>
            <div class="alert alert-warning mt-5" role="alert" v-if="errors">
                <h5>Warning</h5>
                <ul>
                    <li v-for="(error) in errors">{{ error.message }}</li>
                </ul>
            </div>
            
          </div>


      </div>


    </main>

  </div>
</div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted"><a href="https://github.com/trmurakami/online-marc-editor" target="_blank">Online MARC Editor</a> is an Open Source Software created by <a href="https://github.com/trmurakami" target="_blank">Tiago Murakami</a> &middot; 2022</span>
        </div>
    </footer>

    <script src="inc/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="inc/js/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

    <script>
        var app = new Vue({
            el: '#editor',

            data: {                
                ldrShow: false,
                doiShow: false,
                isbnShow: false,
                f008Show: false,

                validation:{
                    _245a: '',
                },
                crossrefRecord: null,
                ISBNRecord: null,
                Z3950Records: null,
                recordType: 'Book',
                translation: [],
                translation_en_US: {
                    _008: '008 - Fixed-Length Data Elements-General Information',
                    _040a: 'Original cataloging agency',
                    _040c: 'Transcribing agency',
                    add_personal_name: 'Add Personal Name',
                    add_rda_fields: 'Add RDA fields (336, 337, 338)',
                    book: 'Book',
                    cataloging_source: 'Cataloging Source',
                    control_number: 'Control Number',
                    control_number_identifier: 'Control Number Identifier',
                    edit_fields: 'Edit fields',
                    leader: 'Leader',
                    predefined_types: 'Predefined types',                
                    serial: 'Serial'
                },
                translation_pt_BR: {
                    _008: '008 - Campo de tamanho fixo',
                    _040a: 'Código da Agência Catalogadora',
                    _040c: 'Agência que transcreveu o registro em formato legível por máquina',
                    add_personal_name: 'Adicionar Nome pessoal',         
                    add_rda_fields: 'Adicionar campos RDA (336, 337, 338)',
                    book: 'Livro',
                    cataloging_source: 'Fonte da Catalogação',
                    control_number: 'Número de controle',
                    control_number_identifier: 'Código MARC da Agência Catalogadora',
                    edit_fields: 'Editar campos',
                    leader: 'Líder',
                    predefined_types: 'Tipos predefinidos',
                    serial: 'Periódico'
                },
                record: {
                    ldr:{
                        record_length: '00000',
                        record_status: 'n',
                        type_of_record: 'a',
                        bibliographic_level: 'm',
                        type_of_control: "#",
                        character_coding_scheme: "a",
                        base_address_of_data:'00000', 
                        encoding_level: "I",
                        descriptive_cataloging_form: "a",
                        multipart_resource_record_level: "#"
                    },
                    f008:{
                        p00_05: '000000',
                        p06: 's',
                        p07_10: '0000',
                        p11_14: '####',
                        p15_17: 'bl#',
                        p18: '#',
                        p19: '#',
                        p20: '#',
                        p21: '#',
                        p22: '#',
                        p23: '#',
                        p24: '#',
                        p25: '#',
                        p26: '#',
                        p27: '#',
                        p28: '#',
                        p29: '0',
                        p30: '0',
                        p31: '0',
                        p32: '#',
                        p33: '0',
                        p34: '#',
                        p35_37: 'por',
                        p38: '#',
                        p39: 'd'
                    },
                    _001: "",
                    _003: "",
                    _005: "",
                    _040a: "",
                    _040c: "",
                    title: "",
                    personal_name: [],
                    personal_names_array: [],
                    corporate_name: [],
                    corporate_names_array: [],
                    _245_ind1: '1',
                    _245_ind2: '0',
                    subtitle: null,
                    _245c: "",
                    doi:null,
                    isbn:[],
                    isbn_array: [],
                    _260_ind1: "#",
                    _260_ind2: "#",
                    _260a: null,
                    _260b: null,
                    _260c: null,
                    _300_ind1: "#",
                    _300_ind2: "#",
                    _300a: null,
                    _300b: null,
                    _300c: null,
                    _310a: null,
                    _336a: null,
                    _3362: 'rdacontent',
                    _337a: null,
                    _3372: 'rdamedia',
                    _338a: null,
                    _3382: 'rdacarrier',
                    general_note: [],
                    general_note_array: [],
                    _650: [],
                    _650_array: [],
                    _856: [],
                    _856_array: []
                },
                copySuccessful: false,
                current_ldr: null,
                loadingDOI: false,
                loadingISBN: false,
                loadingZ3950: false,
                i_personal_name: 1,
                errors: null,
                RDA: false,
                _336b: null,
                _337b: null,
                _338b: null

            },
            computed: {
                complete_record: function(){

                    this.record.isbn_array = [];
                    for (this.i_isbn = 0; this.i_isbn < this.record.isbn.length; this.i_isbn++) {
                        this.record.isbn_array.push('\n=020  ##$a' + this.record.isbn[this.i_isbn].id);
                    }

                    this.record.personal_names_array = [];
                    for (this.i_personal_name = 1; this.i_personal_name < this.record.personal_name.length; this.i_personal_name++) {
                        this.record.personal_names_array.push('\n=700  ' + this.record.personal_name[this.i_personal_name].ind1 + '#$a' + this.record.personal_name[this.i_personal_name].a + (this.record.personal_name[this.i_personal_name].d ? '$d' + this.record.personal_name[this.i_personal_name].d : '') + (this.record.personal_name[this.i_personal_name].e ? '$e' + this.record.personal_name[this.i_personal_name].e : '') + (this.record.personal_name[this.i_personal_name].q ? '$q' + this.record.personal_name[this.i_personal_name].q : '') + (this.record.personal_name[this.i_personal_name].u ? '$u' + this.record.personal_name[this.i_personal_name].u : ''));
                    }                    
                    this.i_personal_name = 1;

                    this.record.corporate_names_array = [];
                    for (this.i_corporate_name = 1; this.i_corporate_name < this.record.corporate_name.length; this.i_corporate_name++) {
                        this.record.corporate_names_array.push('\n=710  ' + this.record.corporate_name[this.i_corporate_name].ind1 + '#$a' + this.record.corporate_name[this.i_corporate_name].a + (this.record.corporate_name[this.i_corporate_name].d ? '$d' + this.record.corporate_name[this.i_corporate_name].d : '') + (this.record.corporate_name[this.i_corporate_name].q ? '$q' + this.record.corporate_name[this.i_corporate_name].q : ''));
                    }                    
                    this.i_corporate_name = 1;

                    this.record.general_note_array = [];
                    for (this.i_general_note = 0; this.i_general_note < this.record.general_note.length; this.i_general_note++) {
                        this.record.general_note_array.push('\n=500  ##$a' + this.record.general_note[this.i_general_note].a);
                    }

                    this.record._650_array = [];
                    for (this.i_650 = 0; this.i_650 < this.record._650.length; this.i_650++) {
                        this.record._650_array.push('\n=650  ' + this.record._650[this.i_650].ind1 + this.record._650[this.i_650].ind2 + '$a' + this.record._650[this.i_650].a + (this.record._650[this.i_650].ind2 == '7' ? '$2' + this.record._650[this.i_650]._2 : ''));
                    }

                    this.record._856_array = [];
                    for (this.i_856 = 0; this.i_856 < this.record._856.length; this.i_856++) {
                        this.record._856_array.push('\n=856  ' + this.record._856[this.i_856].ind1 + this.record._856[this.i_856].ind2 + '$u' + this.record._856[this.i_856].u);
                    }

                    return '\n=LDR  ' + this.record.ldr.record_length + this.record.ldr.record_status + this.record.ldr.type_of_record + this.record.ldr.bibliographic_level + this.record.ldr.type_of_control + 
                    this.record.ldr.character_coding_scheme + '22' + this.record.ldr.base_address_of_data + this.record.ldr.encoding_level + this.record.ldr.descriptive_cataloging_form + 
                    this.record.ldr.multipart_resource_record_level + '4500' +
                    '\n=001  ' + this.record._001 +
                    '\n=003  ' + this.record._003 +
                    '\n=005  ' + this.record._005 +
                    '\n=008  ' + this.record.f008.p00_05 + this.record.f008.p06 + this.record.f008.p07_10 + this.record.f008.p11_14 + this.record.f008.p15_17 + this.record.f008.p18 + this.record.f008.p19 + 
                    this.record.f008.p20 + this.record.f008.p21 + this.record.f008.p22 + this.record.f008.p23 +
                    this.record.f008.p24 + this.record.f008.p25 + this.record.f008.p26 + this.record.f008.p27 + this.record.f008.p28 + this.record.f008.p29 + this.record.f008.p30 + this.record.f008.p31 + this.record.f008.p32 +
                    this.record.f008.p33 + this.record.f008.p34 +  this.record.f008.p35_37 + this.record.f008.p38 + this.record.f008.p39 +
                    this.record.isbn_array.join("") +
                    (this.record.doi ? '\n=024  70$a' + this.record.doi + '$2doi': '') +
                    '\n=040  ##$a' + this.record._040a + '$c' + this.record._040c +
                    (this.record.personal_name[0] ? '\n=100  ' + this.record.personal_name[0].ind1 + '#$a' + this.record.personal_name[0].a + 
                        (this.record.personal_name[0].d ? '$d' + this.record.personal_name[0].d : '') +
                        (this.record.personal_name[0].e ? '$e' + this.record.personal_name[0].e : '') +
                        (this.record.personal_name[0].q ? '$q' + this.record.personal_name[0].q : '') + 
                        (this.record.personal_name[0].u ? '$u' + this.record.personal_name[0].u : '') : '') +
                    (this.record.corporate_name[0] ? '\n=110  ' + this.record.corporate_name[0].ind1 + '#$a' + this.record.corporate_name[0].a + (this.record.corporate_name[0].d ? '$d' + this.record.corporate_name[0].d : '') + (this.record.corporate_name[0].q ? '$q' + this.record.corporate_name[0].q : '') : '') +
                    '\n=245  ' + this.record._245_ind1 + this.record._245_ind2 + '$a' + this.record.title +
                    (this.record.subtitle ? '$b' + this.record.subtitle : '') +
                    (this.record._245c ? '$c' + this.record._245c : '') +
                    '\n=260  ' + this.record._260_ind1 + this.record._260_ind2 + (this.record._260a ? '$a' + this.record._260a : '') + 
                    (this.record._260b ? '$b' + this.record._260b : '') + (this.record._260c ? '$c' + this.record._260c : '') +
                    '\n=300  ' + this.record._300_ind1 + this.record._300_ind2 + (this.record._300a ? '$a' + this.record._300a : '') + 
                    (this.record._300b ? '$b' + this.record._300b : '') + (this.record._300c ? '$c' + this.record._300c : '') +
                    (this.record._310a ? '\n=310 ##$a' + this.record._310a : '') +   
                    (this.record._336a ? '\n=336 ##$a' + this.record._336a + (this._336b ? '$b' + this._336b : '') + '$2' + this.record._3362 : '') +
                    (this.record._337a ? '\n=337 ##$a' + this.record._337a + (this._337b ? '$b' + this._337b : '') + '$2' + this.record._3372 : '') +
                    (this.record._338a ? '\n=338 ##$a' + this.record._338a + (this._338b ? '$b' + this._338b : '') + '$2' + this.record._3382 : '') +
                    this.record.general_note_array.join("") +
                    this.record._650_array.join("") +
                    this.record.personal_names_array.join("") +
                    this.record.corporate_names_array.join("") +
                    this.record._856_array.join("")

                },
                _336b: function (){
                    switch (this.record._336a) {
                        case "cartographic dataset":
                            return 'crd'; 
                            break;
                        case "cartographic image":
                            return 'cri'; 
                            break;
                        case "cartographic moving image":
                            return 'crm'; 
                            break;
                        case "cartographic tactile image":
                            return 'crt'; 
                            break;
                        case "cartographic tactile three-dimensional form":
                            return 'crn'; 
                            break;
                        case "cartographic three-dimensional form":
                            return 'crf'; 
                            break;
                        case "computer dataset":
                            return 'cod'; 
                            break;
                        case "computer program":
                            return 'cop'; 
                            break;
                        case "notated movement":
                            return 'ntv'; 
                            break;
                        case "notated music":
                            return 'ntm'; 
                            break;
                        case "performed music":
                            return 'prm'; 
                            break;
                        case "sounds":
                            return 'snd'; 
                            break;
                        case "spoken word":
                            return 'spw'; 
                            break;
                        case "still image":
                            return 'sti'; 
                            break;
                        case "tactile image":
                            return 'tci'; 
                            break;
                        case "tactile notated music":
                            return 'tcm'; 
                            break;
                        case "tactile notated movement":
                            return 'tcn'; 
                            break;
                        case "tactile text":
                            return 'tct'; 
                            break;
                        case "tactile three-dimensional form":
                            return 'tcf'; 
                            break;
                        case "text":
                            return 'txt'; 
                            break;
                        case "three-dimensional form":
                            return 'tdf'; 
                            break;
                        case "three-dimensional moving image":
                            return 'tdm'; 
                            break;
                        case "two-dimensional moving image":
                            return 'tdi'; 
                            break;
                        case "other":
                            return 'xxx'; 
                            break;
                        case "unspecified":
                            return 'zzz'; 
                            break;
                        default:
                        return null;
                    }

                },
                _337b: function (){
                    switch (this.record._337a) {
                        case "audio":
                            return 's'; 
                            break;
                        case "computer":
                            return 'c'; 
                            break;
                        case "microform":
                            return 'h'; 
                            break;
                        case "microscopic":
                            return 'p'; 
                            break;
                        case "projected":
                            return 'g'; 
                            break;
                        case "stereographic":
                            return 'e'; 
                            break;
                        case "unmediated":
                            return 'n'; 
                            break;
                        case "video":
                            return 'v'; 
                            break;
                        case "other":
                            return 'x'; 
                            break;
                        case "unspecified":
                            return 'z'; 
                            break;
                        default:
                        return null;
                    }

                },
                _338b: function (){
                    switch (this.record._338a) {
                        case "audio cartridge":
                            return 'sg'; 
                            break;
                        case "audio belt":
                            return 'sb'; 
                            break;
                        case "audio cylinder":
                            return 'se'; 
                            break;
                        case "audio disc":
                            return 'sd'; 
                            break;
                        case "sound track reel":
                            return 'si'; 
                            break;
                        case "audio roll":
                            return 'sq'; 
                            break;
                        case "audio wire reel":
                            return 'sw'; 
                            break;
                        case "audiocassette":
                            return 'ss'; 
                            break;
                        case "audiotape reel":
                            return 'st'; 
                            break;
                        case "other":
                            return 'nz'; 
                            break;
                        case "computer card":
                            return 'ck'; 
                            break;
                        case "computer chip cartridge":
                            return 'cb'; 
                            break;
                        case "computer disc":
                            return 'cd'; 
                            break;
                        case "computer disc cartridge":
                            return 'ce'; 
                            break;
                        case "computer tape cartridge":
                            return 'ca'; 
                            break;
                        case "computer tape cassette":
                            return 'cf'; 
                            break;
                        case "computer tape reel":
                            return 'ch'; 
                            break;
                        case "online resource":
                            return 'cr'; 
                            break;
                        case "aperture card":
                            return 'ha'; 
                            break;
                        case "microfiche":
                            return 'he'; 
                            break;
                        case "microfiche cassette":
                            return 'hf'; 
                            break;
                        case "microfilm cartridge":
                            return 'hb'; 
                            break;
                        case "microfilm cassette":
                            return 'hc'; 
                            break;
                        case "microfilm reel":
                            return 'hd'; 
                            break;
                        case "microfilm roll":
                            return 'hj'; 
                            break;
                        case "microfilm slip":
                            return 'hh'; 
                            break;
                        case "microopaque":
                            return 'hg'; 
                            break;
                        case "microscope slide":
                            return 'pp'; 
                            break;
                        case "film cartridge":
                            return 'mc'; 
                            break;
                        case "film cassette":
                            return 'mf'; 
                            break;
                        case "film reel":
                            return 'mr'; 
                            break;
                        case "film roll":
                            return 'mo'; 
                            break;
                        case "filmslip":
                            return 'gd'; 
                            break;
                        case "filmstrip":
                            return 'gf'; 
                            break;
                        case "filmstrip cartridge":
                            return 'gc'; 
                            break;
                        case "overhead transparency":
                            return 'gt'; 
                            break;
                        case "slide":
                            return 'gs'; 
                            break;
                        case "stereograph card":
                            return 'eh'; 
                            break;
                        case "stereograph disc":
                            return 'es'; 
                            break;
                        case "card":
                            return 'no'; 
                            break;
                        case "flipchart":
                            return 'nn'; 
                            break;
                        case "roll":
                            return 'na'; 
                            break;
                        case "sheet":
                            return 'nb'; 
                            break;
                        case "volume":
                            return 'nc'; 
                            break;
                        case "object":
                            return 'nr'; 
                            break;
                        case "video cartridge":
                            return 'vc'; 
                            break;
                        case "videocassette":
                            return 'vf'; 
                            break;
                        case "videodisc":
                            return 'vd'; 
                            break;
                        case "videotape reel":
                            return 'vr'; 
                            break;
                        case "unspecified ":
                            return 'zu'; 
                            break;
                        default:
                        return null;
                    }

                } 

            },
            mounted() {
                this.update005();
                this.translation = this.translation_en_US;
            },
            methods: {
                addField: function (field) {
                    if (this.record[field] === null) {
                        this.record[field] = [];
                    }
                    switch (field) {
                        case "isbn":
                            this.record[field].push({ id: "" });
                            break;
                        case "personal_name":
                            this.record[field].push({ ind1: "1", a: "", d: null, q: null });
                            break;
                        case "corporate_name":
                            this.record[field].push({ ind1: "2", a: "" });
                            break;
                        case "_650":
                            this.record[field].push({ ind1: "0", ind2: "4", a: "", _2: ""});
                            break;
                        case "_856":
                            this.record[field].push({ ind1: "4", ind2: "0", u: ""});
                            break;
                        case "general_note":
                            this.record[field].push({ a: ""});
                            break;
                        case "_536":
                            this.record[field].push({ a: "", f: ""});
                            break;
                        default:
                        this.record[field].push({ a: ""});
                    }
                },
                cleanAll () {
                    document.location.reload(true);
                },
                copyTestingCode () {
                    try {
                        var successful = navigator.clipboard.writeText(this.complete_record);
                        var msg = successful ? 'successful' : 'unsuccessful';
                        this.copySuccessful = true
                        setTimeout(() => {   this.copySuccessful = false; }, 2000);
                    } catch (err) {
                        alert('Oops, unable to copy');
                    }
                },
                deleteField: function (field, index) {
                    this.record[field].splice(index, 1);
                },
                getDOI(doi) {
                    axios
                        .get("https://api.crossref.org/works/" + doi)
                        .then((response) => {
                        this.crossrefRecord = response,
                        this.record.title = this.crossrefRecord.data.message.title,
                        this.record._856u = this.crossrefRecord.data.message.URL,
                        this.record._260b = this.crossrefRecord.data.message.publisher,
                        this.record._260c = this.crossrefRecord.data.message.issued['date-parts'][0][0],
                        this.record.f008.p07_10 = this.crossrefRecord.data.message.issued['date-parts'][0][0]
                        Object.values(this.crossrefRecord.data.message.author).forEach(val => {
                            this.record.personal_name.push({ ind1: '1', a: val.family + ', ' + val.given });
                        });
                        if (this.crossrefRecord.data.message.ISBN) {
                            this.record.isbn = this.crossrefRecord.data.message.ISBN[0]
                        }
                        switch (this.crossrefRecord.data.message.language) {
                            case "en":
                                this.record.f008.p35_37 = 'eng';
                                break;
                        }

                        })
                        .catch(function (error) {
                        console.log(error);
                        this.errored = true;
                        })
                        .finally(() => (this.loadingDOI = false));
                },
                getISBNGoogleBooks(isbn) {
                    axios
                        .get("https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbn)
                        .then((response) => {
                        this.ISBNRecord = response.data,
                        this.record.title = this.ISBNRecord.items[0].volumeInfo.title,
                        //this.record.abstract = this.ISBNRecord.items.[0].volumeInfo.description,
                        this.record._260c = this.ISBNRecord.items[0].volumeInfo.publishedDate,
                        this.record.f008.p07_10 = this.ISBNRecord.items[0].volumeInfo.publishedDate
                        this.record._300a = this.ISBNRecord.items[0].volumeInfo.pageCount + 'p.'
                        Object.values(this.ISBNRecord.items[0].volumeInfo.authors).forEach(val => {
                           this.record.author.push({ ind1: '1', a: val });
                        });
                        })
                        .catch(function (error) {
                        console.log(error);
                        this.errored = true;
                        })
                        .finally(() => (this.loadingISBN = false));
                },
                getZ3950(isbn, host, hostname) {
                    axios
                    .get("proxy.php?url=http://tecbib.com/api/z3950?isbn=" + isbn + '%26host=' + host)
                    .then((response) => {
                    if(this.Z3950Records !== null) {
                        Object.values(response.data).forEach(val => {
                        val["source"] =hostname;
                        this.Z3950Records.push(val);
                        });
                    } else {
                        this.Z3950Records = Array ();
                        Object.values(response.data).forEach(val => {
                        val["source"] =hostname;
                        this.Z3950Records.push(val);
                        });
                    }
                    })
                    .catch(function (error) {
                    console.log(error);
                    this.errored = true;
                    })
                    .finally(() => (this.loadingZ3950 = false));
                },
                translate(language) {
                    switch (language) {
                        case "pt_BR":
                            this.translation = this.translation_pt_BR;
                            break;
                        case "en_US":
                            this.translation = this.translation_en_US;
                            break;
                        default:
                            this.translation = this.translation_en_US;
                    }
                },
                update005() {
                    let today = new Date().toISOString().replace('-', '').replace('-', '').replace('T', '').replace(':', '').replace(':', '').substr(0,16);
                    this.record._005 = today
                },
                validate() {
                    this.errors = null;
                    if (this.record.title == "") {
                        this.validation._245a = "is-invalid";
                        if (this.errors == null) {
                            this.errors = [];
                        }                                             
                        this.errors.push({ message:'Title is mandatory' });
                    } else {
                        this.validation._245a = "is-valid";
                    }
                    if (this.record.f008.p07_10.length != 4) {
                        if (this.errors == null) {
                            this.errors = [];
                        }     
                        this.errors.push({ message:'008 position 07-10 has invalid length (4 is mandatory)' });
                    }
                    if (isNaN(this.record.f008.p07_10)) {
                        if (this.errors == null) {
                            this.errors = [];
                        }     
                        this.errors.push({ message:'008 position 07-10 is not a valid number' });
                    }
                    if (this.record.f008.p07_10 == '0000') {
                        if (this.errors == null) {
                            this.errors = [];
                        }     
                        this.errors.push({ message:'008 position 07-10 is not a valid number' });
                    }
                }
            }
        })
    </script>

  </body>
</html>