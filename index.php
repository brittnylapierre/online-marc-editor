<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">




    <title>Online MARC Editor</title>
  </head>
  <body>
        <header class="p-5 pb-0">
            <h1>Online MARC Editor</h1>
            <p>An online editor to create MARC records (<a href="https://www.loc.gov/marc/bibliographic/bdapndxc.html" target="_blank">Minimal Level Record</a>)</p>
        </header>
        <main>
            <div id="editor">

                <div class="row">
                    <div class="col-md-8 p-5 pt-2" >
                        

                        <button v-on:click="ldrShow = !ldrShow" type="button" class="btn btn-primary">LDR</button>
                        <button v-on:click="f008Show = !f008Show" type="button" class="btn btn-primary">008</button>
                        <button v-on:click="doiShow = !doiShow" type="button" class="btn btn-primary">DOI</button>
                        <button v-on:click="isbnShow = !isbnShow" type="button" class="btn btn-primary">ISBN</button>

                        <!-- 008 -->
                        <div v-show="f008Show" class="alert alert-warning alert-dismissible fade show" role="alert">

                            <label for="record_status">06 - Type of date/Publication status</label>
                            <select class="form-select" aria-label="Record status" id="record_status" v-model="f008.p06">
                                <option value="b">No dates given; B.C. date involved</option>
                                <option value="c">Continuing resource currently published</option>
                                <option value="d">Continuing resource ceased publication</option>
                                <option value="e">Detailed date</option>
                                <option value="i">Inclusive dates of collection</option>
                                <option value="k">Range of years of bulk of collection</option>
                                <option value="m">Multiple dates</option>
                                <option value="n">Dates unknown</option>
                                <option value="p">Date of distribution/release/issue and production/recording session when different</option>
                                <option value="q">Questionable date</option>
                                <option value="r">Reprint/reissue date and original date</option>
                                <option value="s">Single known date/probable date</option>
                                <option value="t">Publication date and copyright date</option>
                                <option value="i">Continuing resource status unknown</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="008_07_10">07-10 - Date 1</label>
                            <input type="text" id="008_07_10" v-model="f008.p07_10" class="form-control" aria-label="008_07_10" aria-describedby="008_07_10" maxlength="4">

                            <label for="008_11_14">11-14 - Date 2</label>
                            <input type="text" id="008_11_14" v-model="f008.p11_14" class="form-control" aria-label="008_11_14" aria-describedby="008_11_14" maxlength="4">

                            <label for="008_15_17">15-17 - Place of publication, production, or execution</label>
                            <select class="form-select selectpicker" aria-label="Place of publication" id="008_15_17" v-model="f008.p15_17" data-live-search="true">
                                <option value="xx#">No place, unknown, or undetermined</option>
                                <option value="vp#">Various places</option>
                                <option value="bl#">Brazil</option>
                                <option value="aa#">Albania</option>
                                <option value="abc">Alberta</option>
                                <option value="-ac">Ashmore and Cartier Islands</option>
                                <option value="aca">Australian Capital Territory</option>
                                <option value="ae#">Algeria</option>
                                <option value="af#">Afghanistan</option>
                                <option value="ag#">Argentina</option>
                                <option value="-ai">Anguilla</option>
                                <option value="ai#">Armenia (Republic)</option>
                                <option value="air">Armenian S.S.R.</option>
                                <option value="aj#">Azerbaijan</option>
                                <option value="ajr">Azerbaijan S.S.R.</option>
                                <option value="aku">Alaska</option>
                                <option value="alu">Alabama</option>
                                <option value="am#">Anguilla</option>
                                <option value="an#">Andorra</option>
                                <option value="ao#">Angola</option>
                                <option value="aq#">Antigua and Barbuda</option>
                                <option value="aru">Arkansas</option>
                                <option value="as#">American Samoa</option>
                                <option value="at#">Australia</option>
                                <option value="au#">Austria</option>
                                <option value="aw#">Aruba</option>
                                <option value="ay#">Antarctica</option>
                                <option value="azu">Arizona</option>
                                <option value="ba#">Bahrain</option>
                                <option value="bb#">Barbados</option>
                                <option value="bcc">British Columbia</option>
                                <option value="bd#">Burundi</option>
                                <option value="be#">Belgium</option>
                                <option value="bf#">Bahamas</option>
                                <option value="bg#">Bangladesh</option>
                                <option value="bh#">Belize</option>
                                <option value="bi#">British Indian Ocean Territory</option>
                                <option value="bl#">Brazil</option>
                                <option value="bm#">Bermuda Islands</option>
                                <option value="bn#">Bosnia and Herzegovina</option>
                                <option value="bo#">Bolivia</option>
                                <option value="bp#">Solomon Islands</option>
                                <option value="br#">Burma</option>
                                <option value="bs#">Botswana</option>
                                <option value="bt#">Bhutan</option>
                                <option value="bu#">Bulgaria</option>
                                <option value="bv#">Bouvet Island</option>
                                <option value="bw#">Belarus</option>
                                <option value="bwr">Byelorussian S.S.R.</option>
                                <option value="bx#">Brunei</option>
                                <option value="ca#">Caribbean Netherlands</option>
                                <option value="cau">California</option>
                                <option value="cb#">Cambodia</option>
                                <option value="cc#">China</option>
                                <option value="cd#">Chad</option>
                                <option value="ce#">Sri Lanka</option>
                                <option value="cf#">Congo (Brazzaville)</option>
                                <option value="cg#">Congo (Democratic Republic)</option>
                                <option value="ch#">China (Republic : 1949- )</option>
                                <option value="ci#">Croatia</option>
                                <option value="cj#">Cayman Islands</option>
                                <option value="ck#">Colombia</option>
                                <option value="cl#">Chile</option>
                                <option value="cm#">Cameroon</option>
                                <option value="-cn">Canada</option>
                                <option value="co#">Curaçao</option>
                                <option value="cou">Colorado</option>
                                <option value="-cp">Canton and Enderbury Islands</option>
                                <option value="cq#">Comoros</option>
                                <option value="cr#">Costa Rica</option>
                                <option value="-cs">Czechoslovakia</option>
                                <option value="ctu">Connecticut</option>
                                <option value="cu#">Cuba</option>
                                <option value="cv#">Cabo Verde</option>
                                <option value="cw#">Cook Islands</option>
                                <option value="cx#">Central African Republic</option>
                                <option value="cy#">Cyprus</option>
                                <option value="-cz">Canal Zone</option>
                                <option value="dcu">District of Columbia</option>
                                <option value="deu">Delaware</option>
                                <option value="dk#">Denmark</option>
                                <option value="dm#">Benin</option>
                                <option value="dq#">Dominica</option>
                                <option value="dr#">Dominican Republic</option>
                                <option value="ea#">Eritrea</option>
                                <option value="ec#">Ecuador</option>
                                <option value="eg#">Equatorial Guinea</option>
                                <option value="em#">Timor-Leste</option>
                                <option value="enk">England</option>
                                <option value="er#">Estonia</option>
                                <option value="err">Estonia</option>
                                <option value="es#">El Salvador</option>
                                <option value="et#">Ethiopia</option>
                                <option value="fa#">Faroe Islands</option>
                                <option value="fg#">French Guiana</option>
                                <option value="fi#">Finland</option>
                                <option value="fj#">Fiji</option>
                                <option value="fk#">Falkland Islands</option>
                                <option value="flu">Florida</option>
                                <option value="fm#">Micronesia (Federated States)</option>
                                <option value="fp#">French Polynesia</option>
                                <option value="fr#">France</option>
                                <option value="fs#">Terres australes et antarctiques françaises</option>
                                <option value="ft#">Djibouti</option>
                                <option value="gau">Georgia</option>
                                <option value="gb#">Kiribati</option>
                                <option value="gd#">Grenada</option>
                                <option value="-ge">Germany (East)</option>
                                <option value="gg#">Guernsey</option>
                                <option value="gh#">Ghana</option>
                                <option value="gi#">Gibraltar</option>
                                <option value="gl#">Greenland</option>
                                <option value="gm#">Gambia</option>
                                <option value="-gn">Gilbert and Ellice Islands</option>
                                <option value="go#">Gabon</option>
                                <option value="gp#">Guadeloupe</option>
                                <option value="gr#">Greece</option>
                                <option value="gs#">Georgia (Republic)</option>
                                <option value="gsr">Georgian S.S.R.</option>
                                <option value="gt#">Guatemala</option>
                                <option value="gu#">Guam</option>
                                <option value="gv#">Guinea</option>
                                <option value="gw#">Germany</option>
                                <option value="gy#">Guyana</option>
                                <option value="gz#">Gaza Strip</option>
                                <option value="hiu">Hawaii</option>
                                <option value="-hk">Hong Kong</option>
                                <option value="hm#">Heard and McDonald Islands</option>
                                <option value="ho#">Honduras</option>
                                <option value="ht#">Haiti</option>
                                <option value="hu#">Hungary</option>
                                <option value="iau">Iowa</option>
                                <option value="ic#">Iceland</option>
                                <option value="idu">Idaho</option>
                                <option value="ie#">Ireland</option>
                                <option value="ii#">India</option>
                                <option value="ilu">Illinois</option>
                                <option value="im#">Isle of Man</option>
                                <option value="inu">Indiana</option>
                                <option value="io#">Indonesia</option>
                                <option value="iq#">Iraq</option>
                                <option value="ir#">Iran</option>
                                <option value="is#">Israel</option>
                                <option value="it#">Italy</option>
                                <option value="-iu">Israel-Syria Demilitarized Zones</option>
                                <option value="iv#">Côte d'Ivoire</option>
                                <option value="-iw">Israel-Jordan Demilitarized Zones</option>
                                <option value="iy#">Iraq-Saudi Arabia Neutral Zone</option>
                                <option value="ja#">Japan</option>
                                <option value="je#">Jersey</option>
                                <option value="ji#">Johnston Atoll</option>
                                <option value="jm#">Jamaica</option>
                                <option value="-jn">Jan Mayen</option>
                                <option value="jo#">Jordan</option>
                                <option value="ke#">Kenya</option>
                                <option value="kg#">Kyrgyzstan</option>
                                <option value="kgr">Kirghiz S.S.R.</option>
                                <option value="kn#">Korea (North)</option>
                                <option value="ko#">Korea (South)</option>
                                <option value="ksu">Kansas</option>
                                <option value="ku#">Kuwait</option>
                                <option value="kv#">Kosovo</option>
                                <option value="kyu">Kentucky</option>
                                <option value="kz#">Kazakhstan</option>
                                <option value="kzr">Kazakh S.S.R.</option>
                                <option value="lau">Louisiana</option>
                                <option value="lb#">Liberia</option>
                                <option value="le#">Lebanon</option>
                                <option value="lh#">Liechtenstein</option>
                                <option value="li#">Lithuania</option>
                                <option value="lir">Lithuania</option>
                                <option value="-ln">Central and Southern Line Islands</option>
                                <option value="lo#">Lesotho</option>
                                <option value="ls#">Laos</option>
                                <option value="lu#">Luxembourg</option>
                                <option value="lv#">Latvia</option>
                                <option value="lvr">Latvia</option>
                                <option value="ly#">Libya</option>
                                <option value="mau">Massachusetts</option>
                                <option value="mbc">Manitoba</option>
                                <option value="mc#">Monaco</option>
                                <option value="mdu">Maryland</option>
                                <option value="meu">Maine</option>
                                <option value="mf#">Mauritius</option>
                                <option value="mg#">Madagascar</option>
                                <option value="-mh">Macao</option>
                                <option value="miu">Michigan</option>
                                <option value="mj#">Montserrat</option>
                                <option value="mk#">Oman</option>
                                <option value="ml#">Mali</option>
                                <option value="mm#">Malta</option>
                                <option value="mnu">Minnesota</option>
                                <option value="mo#">Montenegro</option>
                                <option value="mou">Missouri</option>
                                <option value="mp#">Mongolia</option>
                                <option value="mq#">Martinique</option>
                                <option value="mr#">Morocco</option>
                                <option value="msu">Mississippi</option>
                                <option value="mtu">Montana</option>
                                <option value="mu#">Mauritania</option>
                                <option value="mv#">Moldova</option>
                                <option value="mvr">Moldavian S.S.R.</option>
                                <option value="mw#">Malawi</option>
                                <option value="mx#">Mexico</option>
                                <option value="my#">Malaysia</option>
                                <option value="mz#">Mozambique</option>
                                <option value="-na">Netherlands Antilles</option>
                                <option value="nbu">Nebraska</option>
                                <option value="ncu">North Carolina</option>
                                <option value="ndu">North Dakota</option>
                                <option value="ne#">Netherlands</option>
                                <option value="nfc">Newfoundland and Labrador</option>
                                <option value="ng#">Niger</option>
                                <option value="nhu">New Hampshire</option>
                                <option value="nik">Northern Ireland</option>
                                <option value="nju">New Jersey</option>
                                <option value="nkc">New Brunswick</option>
                                <option value="nl#">New Caledonia</option>
                                <option value="-nm">Northern Mariana Islands</option>
                                <option value="nmu">New Mexico</option>
                                <option value="nn#">Vanuatu</option>
                                <option value="no#">Norway</option>
                                <option value="np#">Nepal</option>
                                <option value="nq#">Nicaragua</option>
                                <option value="nr#">Nigeria</option>
                                <option value="nsc">Nova Scotia</option>
                                <option value="ntc">Northwest Territories</option>
                                <option value="nu#">Nauru</option>
                                <option value="nuc">Nunavut</option>
                                <option value="nvu">Nevada</option>
                                <option value="nw#">Northern Mariana Islands</option>
                                <option value="nx#">Norfolk Island</option>
                                <option value="nyu">New York (State)</option>
                                <option value="nz#">New Zealand</option>
                                <option value="ohu">Ohio</option>
                                <option value="oku">Oklahoma</option>
                                <option value="onc">Ontario</option>
                                <option value="oru">Oregon</option>
                                <option value="ot#">Mayotte</option>
                                <option value="pau">Pennsylvania</option>
                                <option value="pc#">Pitcairn Island</option>
                                <option value="pe#">Peru</option>
                                <option value="pf#">Paracel Islands</option>
                                <option value="pg#">Guinea-Bissau</option>
                                <option value="ph#">Philippines</option>
                                <option value="pic">Prince Edward Island</option>
                                <option value="pk#">Pakistan</option>
                                <option value="pl#">Poland</option>
                                <option value="pn#">Panama</option>
                                <option value="po#">Portugal</option>
                                <option value="pp#">Papua New Guinea</option>
                                <option value="pr#">Puerto Rico</option>
                                <option value="-pt">Portuguese Timor</option>
                                <option value="pw#">Palau</option>
                                <option value="py#">Paraguay</option>
                                <option value="qa#">Qatar</option>
                                <option value="qea">Queensland</option>
                                <option value="quc">Québec (Province)</option>
                                <option value="rb#">Serbia</option>
                                <option value="re#">Réunion</option>
                                <option value="rh#">Zimbabwe</option>
                                <option value="riu">Rhode Island</option>
                                <option value="rm#">Romania</option>
                                <option value="ru#">Russia (Federation)</option>
                                <option value="rur">Russian S.F.S.R.</option>
                                <option value="rw#">Rwanda</option>
                                <option value="-ry">Ryukyu Islands, Southern</option>
                                <option value="sa#">South Africa</option>
                                <option value="-sb">Svalbard</option>
                                <option value="sc#">Saint-Barthélemy</option>
                                <option value="scu">South Carolina</option>
                                <option value="sd#">South Sudan</option>
                                <option value="sdu">South Dakota</option>
                                <option value="se#">Seychelles</option>
                                <option value="sf#">Sao Tome and Principe</option>
                                <option value="sg#">Senegal</option>
                                <option value="sh#">Spanish North Africa</option>
                                <option value="si#">Singapore</option>
                                <option value="sj#">Sudan</option>
                                <option value="-sk">Sikkim</option>
                                <option value="sl#">Sierra Leone</option>
                                <option value="sm#">San Marino</option>
                                <option value="sn#">Sint Maarten</option>
                                <option value="snc">Saskatchewan</option>
                                <option value="so#">Somalia</option>
                                <option value="sp#">Spain</option>
                                <option value="sq#">Eswatini</option>
                                <option value="sr#">Surinam</option>
                                <option value="ss#">Western Sahara</option>
                                <option value="st#">Saint-Martin</option>
                                <option value="stk">Scotland</option>
                                <option value="su#">Saudi Arabia</option>
                                <option value="-sv">Swan Islands</option>
                                <option value="sw#">Sweden</option>
                                <option value="sx#">Namibia</option>
                                <option value="sy#">Syria</option>
                                <option value="sz#">Switzerland</option>
                                <option value="ta#">Tajikistan</option>
                                <option value="tar">Tajik S.S.R.</option>
                                <option value="tc#">Turks and Caicos Islands</option>
                                <option value="tg#">Togo</option>
                                <option value="th#">Thailand</option>
                                <option value="ti#">Tunisia</option>
                                <option value="tk#">Turkmenistan</option>
                                <option value="tkr">Turkmen S.S.R.</option>
                                <option value="tl#">Tokelau</option>
                                <option value="tma">Tasmania</option>
                                <option value="tnu">Tennessee</option>
                                <option value="to#">Tonga</option>
                                <option value="tr#">Trinidad and Tobago</option>
                                <option value="ts#">United Arab Emirates</option>
                                <option value="-tt">Trust Territory of the Pacific Islands</option>
                                <option value="tu#">Turkey</option>
                                <option value="tv#">Tuvalu</option>
                                <option value="txu">Texas</option>
                                <option value="tz#">Tanzania</option>
                                <option value="ua#">Egypt</option>
                                <option value="uc#">United States Misc. Caribbean Islands</option>
                                <option value="ug#">Uganda</option>
                                <option value="-ui">United Kingdom Misc. Islands</option>
                                <option value="uik">United Kingdom Misc. Islands</option>
                                <option value="-uk">United Kingdom</option>
                                <option value="un#">Ukraine</option>
                                <option value="unr">Ukraine</option>
                                <option value="up#">United States Misc. Pacific Islands</option>
                                <option value="-ur">Soviet Union</option>
                                <option value="-us">United States</option>
                                <option value="utu">Utah</option>
                                <option value="uv#">Burkina Faso</option>
                                <option value="uy#">Uruguay</option>
                                <option value="uz#">Uzbekistan</option>
                                <option value="uzr">Uzbek S.S.R.</option>
                                <option value="vau">Virginia</option>
                                <option value="vb#">British Virgin Islands</option>
                                <option value="vc#">Vatican City</option>
                                <option value="ve#">Venezuela</option>
                                <option value="vi#">Virgin Islands of the United States</option>
                                <option value="vm#">Vietnam</option>
                                <option value="-vn">Vietnam, North</option>
                                <option value="vp#">Various places</option>
                                <option value="vra">Victoria</option>
                                <option value="-vs">Vietnam, South</option>
                                <option value="vtu">Vermont</option>
                                <option value="wau">Washington (State)</option>
                                <option value="-wb">West Berlin</option>
                                <option value="wea">Western Australia</option>
                                <option value="wf#">Wallis and Futuna</option>
                                <option value="wiu">Wisconsin</option>
                                <option value="wj#">West Bank of the Jordan River</option>
                                <option value="wk#">Wake Island</option>
                                <option value="wlk">Wales</option>
                                <option value="ws#">Samoa</option>
                                <option value="wvu">West Virginia</option>
                                <option value="wyu">Wyoming</option>
                                <option value="xa#">Christmas Island (Indian Ocean)</option>
                                <option value="xb#">Cocos (Keeling) Islands</option>
                                <option value="xc#">Maldives</option>
                                <option value="xd#">Saint Kitts-Nevis</option>
                                <option value="xe#">Marshall Islands</option>
                                <option value="xf#">Midway Islands</option>
                                <option value="xga">Coral Sea Islands Territory</option>
                                <option value="xh#">Niue</option>
                                <option value="-xi">Saint Kitts-Nevis-Anguilla</option>
                                <option value="xj#">Saint Helena</option>
                                <option value="xk#">Saint Lucia</option>
                                <option value="xl#">Saint Pierre and Miquelon</option>
                                <option value="xm#">Saint Vincent and the Grenadines</option>
                                <option value="xn#">North Macedonia</option>
                                <option value="xna">New South Wales</option>
                                <option value="xo#">Slovakia</option>
                                <option value="xoa">Northern Territory</option>
                                <option value="xp#">Spratly Island</option>
                                <option value="xr#">Czech Republic</option>
                                <option value="xra">South Australia</option>
                                <option value="xs#">South Georgia and the South Sandwich Islands</option>
                                <option value="xv#">Slovenia</option>
                                <option value="xx#">No place, unknown, or undetermined</option>
                                <option value="xxc">Canada</option>
                                <option value="xxk">United Kingdom</option>
                                <option value="xxr">Soviet Union</option>
                                <option value="xxu">United States</option>
                                <option value="ye#">Yemen</option>
                                <option value="ykc">Yukon Territory</option>
                                <option value="-ys">Yemen (People's Democratic Republic)</option>
                                <option value="-yu">Serbia and Montenegro</option>
                                <option value="za#">Zambia</option>
                            </select>
                            <br/>
                            <label for="p18_21">18-21 - Illustrations (006/01-04)</label>
                            <select class="form-select" aria-label="Illustrations" id="p18_21" v-model="f008.p18_21">
                                <option value="#">No illustrations</option>
                                <option value="a">Illustrations</option>
                                <option value="b">Maps</option>
                                <option value="c">Portraits</option>
                                <option value="d">Charts</option>
                                <option value="e">Plans</option>
                                <option value="f">Plates</option>
                                <option value="g">Music</option>
                                <option value="h">Facsimiles</option>
                                <option value="i">Coats of arms</option>
                                <option value="j">Genealogical tables</option>
                                <option value="k">Forms</option>
                                <option value="l">Samples</option>
                                <option value="m">Phonodisc, phonowire, etc.</option>
                                <option value="o">Photographs</option>
                                <option value="p">Illuminations</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p22">22 - Target audience (006/05)</label>
                            <select class="form-select" aria-label="Target audience" id="p22" v-model="f008.p22">
                                <option value="#">Unknown or not specified</option>
                                <option value="a">Preschool</option>
                                <option value="b">Primary</option>
                                <option value="c">Pre-adolescent</option>
                                <option value="d">Adolescent</option>
                                <option value="e">Adult</option>
                                <option value="f">Specialized</option>
                                <option value="g">General</option>
                                <option value="j">Juvenile</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p23">23 - Form of item (006/06)</label>
                            <select class="form-select" aria-label="Form of item" id="p23" v-model="f008.p23">
                                <option value="#">None of the following</option>
                                <option value="a">Microfilm</option>
                                <option value="b">Microfiche</option>
                                <option value="c">Microopaque</option>
                                <option value="d">Large print</option>
                                <option value="f">Braille</option>
                                <option value="o">Online</option>
                                <option value="q">Direct electronic</option>
                                <option value="r">Regular print reproduction</option>
                                <option value="s">Electronic</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p24">24-27 - Nature of contents (006/07-10)</label>
                            <select class="form-select" aria-label="Nature of contents" id="p24" v-model="f008.p24">
                                <option value="#">No specified nature of contents</option>
                                <option value="a">Abstracts/summaries</option>
                                <option value="b">Bibliographies</option>
                                <option value="c">Catalogs</option>
                                <option value="d">Dictionaries</option>
                                <option value="e">Encyclopedias</option>
                                <option value="f">Handbooks</option>
                                <option value="g">Legal articles</option>
                                <option value="i">Indexes</option>
                                <option value="j">Patent document</option>
                                <option value="k">Discographies</option>
                                <option value="l">Legislation</option>
                                <option value="m">Theses</option>
                                <option value="n">Surveys of literature in a subject area</option>
                                <option value="o">Reviews</option>
                                <option value="p">Programmed texts</option>
                                <option value="q">Filmographies</option>
                                <option value="r">Directories</option>
                                <option value="s">Statistics</option>
                                <option value="t">Technical reports</option>
                                <option value="u">Standards/specifications</option>
                                <option value="v">Legal cases and case notes</option>
                                <option value="w">Law reports and digests</option>
                                <option value="y">Yearbooks</option>
                                <option value="z">Treaties</option>
                                <option value="2">Offprints</option>
                                <option value="5">Calendars</option>
                                <option value="6">Comics/graphic novels</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p25">24-27 - Nature of contents (006/07-10)</label>
                            <select class="form-select" aria-label="Nature of contents" id="p25" v-model="f008.p25">
                                <option value="#">No specified nature of contents</option>
                                <option value="a">Abstracts/summaries</option>
                                <option value="b">Bibliographies</option>
                                <option value="c">Catalogs</option>
                                <option value="d">Dictionaries</option>
                                <option value="e">Encyclopedias</option>
                                <option value="f">Handbooks</option>
                                <option value="g">Legal articles</option>
                                <option value="i">Indexes</option>
                                <option value="j">Patent document</option>
                                <option value="k">Discographies</option>
                                <option value="l">Legislation</option>
                                <option value="m">Theses</option>
                                <option value="n">Surveys of literature in a subject area</option>
                                <option value="o">Reviews</option>
                                <option value="p">Programmed texts</option>
                                <option value="q">Filmographies</option>
                                <option value="r">Directories</option>
                                <option value="s">Statistics</option>
                                <option value="t">Technical reports</option>
                                <option value="u">Standards/specifications</option>
                                <option value="v">Legal cases and case notes</option>
                                <option value="w">Law reports and digests</option>
                                <option value="y">Yearbooks</option>
                                <option value="z">Treaties</option>
                                <option value="2">Offprints</option>
                                <option value="5">Calendars</option>
                                <option value="6">Comics/graphic novels</option>
                                <option value="|">No attempt to code</option>
                            </select>
                    
                            <label for="p26">24-27 - Nature of contents (006/07-10)</label>
                            <select class="form-select" aria-label="Nature of contents" id="p26" v-model="f008.p26">
                                <option value="#">No specified nature of contents</option>
                                <option value="a">Abstracts/summaries</option>
                                <option value="b">Bibliographies</option>
                                <option value="c">Catalogs</option>
                                <option value="d">Dictionaries</option>
                                <option value="e">Encyclopedias</option>
                                <option value="f">Handbooks</option>
                                <option value="g">Legal articles</option>
                                <option value="i">Indexes</option>
                                <option value="j">Patent document</option>
                                <option value="k">Discographies</option>
                                <option value="l">Legislation</option>
                                <option value="m">Theses</option>
                                <option value="n">Surveys of literature in a subject area</option>
                                <option value="o">Reviews</option>
                                <option value="p">Programmed texts</option>
                                <option value="q">Filmographies</option>
                                <option value="r">Directories</option>
                                <option value="s">Statistics</option>
                                <option value="t">Technical reports</option>
                                <option value="u">Standards/specifications</option>
                                <option value="v">Legal cases and case notes</option>
                                <option value="w">Law reports and digests</option>
                                <option value="y">Yearbooks</option>
                                <option value="z">Treaties</option>
                                <option value="2">Offprints</option>
                                <option value="5">Calendars</option>
                                <option value="6">Comics/graphic novels</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p27">24-27 - Nature of contents (006/07-10)</label>
                            <select class="form-select" aria-label="Nature of contents" id="p27" v-model="f008.p27">
                                <option value="#">No specified nature of contents</option>
                                <option value="a">Abstracts/summaries</option>
                                <option value="b">Bibliographies</option>
                                <option value="c">Catalogs</option>
                                <option value="d">Dictionaries</option>
                                <option value="e">Encyclopedias</option>
                                <option value="f">Handbooks</option>
                                <option value="g">Legal articles</option>
                                <option value="i">Indexes</option>
                                <option value="j">Patent document</option>
                                <option value="k">Discographies</option>
                                <option value="l">Legislation</option>
                                <option value="m">Theses</option>
                                <option value="n">Surveys of literature in a subject area</option>
                                <option value="o">Reviews</option>
                                <option value="p">Programmed texts</option>
                                <option value="q">Filmographies</option>
                                <option value="r">Directories</option>
                                <option value="s">Statistics</option>
                                <option value="t">Technical reports</option>
                                <option value="u">Standards/specifications</option>
                                <option value="v">Legal cases and case notes</option>
                                <option value="w">Law reports and digests</option>
                                <option value="y">Yearbooks</option>
                                <option value="z">Treaties</option>
                                <option value="2">Offprints</option>
                                <option value="5">Calendars</option>
                                <option value="6">Comics/graphic novels</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p28">28 - Government publication (006/11)</label>
                            <select class="form-select" aria-label="Government publication" id="p28" v-model="f008.p28">
                                <option value="#">Not a government publication</option>
                                <option value="a">Autonomous or semi-autonomous component</option>
                                <option value="c">Multilocal</option>
                                <option value="f">Federal/national</option>
                                <option value="i">International intergovernmental</option>
                                <option value="l">Local</option>
                                <option value="m">Multistate</option>
                                <option value="o">Government publication-level undetermined</option>
                                <option value="s">State, provincial, territorial, dependent, etc.</option>
                                <option value="u">Unknown if item is government publication</option>
                                <option value="z">Other</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p29">29 - Conference publication (006/12)</label>
                            <select class="form-select" aria-label="Conference publication" id="p29" v-model="f008.p29">
                                <option value="0">Not a conference publication</option>
                                <option value="1">Conference publication</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p30">30 - Festschrift (006/13)</label>
                            <select class="form-select" aria-label="Festschrift" id="p30" v-model="f008.p30">
                                <option value="0">Not a festschrift</option>
                                <option value="1">Festschrift</option>
                                <option value="|">No attempt to code</option>
                            </select>
                     
                            <label for="p31">31 - Index (006/14)</label>
                            <select class="form-select" aria-label="Index" id="p31" v-model="f008.p31">
                                <option value="0">No index</option>
                                <option value="1">Index present</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p33">33 - Literary form (006/16)</label>
                            <select class="form-select" aria-label="Literary form" id="p33" v-model="f008.p33">
                                <option value="0">Not fiction (not further specified)</option>
                                <option value="1">Fiction (not further specified)</option>
                                <option value="d">Dramas</option>
                                <option value="e">Essays</option>
                                <option value="f">Novels</option>
                                <option value="h">Humor, satires, etc.</option>
                                <option value="i">Letters</option>
                                <option value="j">Short stories</option>
                                <option value="m">Mixed forms</option>
                                <option value="p">Poetry</option>
                                <option value="s">Speeches</option>
                                <option value="u">Unknown</option>
                                <option value="|">No attempt to code</option>
                            </select>

                            <label for="p34">34 - Biography (006/17)</label>
                            <select class="form-select" aria-label="Biography" id="p34" v-model="f008.p34">
                                <option value="#">No biographical material</option>
                                <option value="a">Autobiography</option>
                                <option value="b">Individual biography</option>
                                <option value="c">Collective biography</option>
                                <option value="d">Contains biographical information</option>
                                <option value="|">No attempt to code</option>
                            </select>

                        </div>
                        <!-- /008 -->

                        <!-- ISBN -->
                        <div v-show="isbnShow" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="alert alert-warning" role="alert" v-show="loadingISBN">
                                Buscando dados no Google Books ...
                            </div>
                            <div class="alert alert-warning" role="alert" v-show="loadingZ3950">
                                Buscando dados no Z39.50 ...
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend"><span class="input-group-text">ISBN</span></div>
                                <input type="text" class="form-control" v-model.trim="record.isbn" id="isbn" name="isbn" placeholder="Enter ISBN">
                                <button class="btn btn-info btn-sm m-2" @click="getISBNGoogleBooks(record.isbn), loadingISBN = true">Google Books</button>
                                <button class="btn btn-info btn-sm m-2" @click="
                                    getZ3950(record.isbn, 'dedalus.usp.br:9991/usp01', 'USP/DEDALUS'),
                                    getZ3950(record.isbn, 'unesp.alma.exlibrisgroup.com:1921/55UNESP_INST', 'UNESP'),
                                    getZ3950(record.isbn, '162.214.168.248:9998/bib', 'BN'),
                                    loadingZ3950 = true
                                ">Z39.50</button>
                            </div>

                            <div class="alert alert-info alert-dismissible fade show bg-opacity-10" role="alert">
                                <table class="table p-2 text-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fonte</th>
                                            <th scope="col">Título</th>
                                            <th scope="col">Autor</th>
                                            <th scope="col">Outros autores</th>
                                            <th scope="col">Editora</th>
                                            <th scope="col">Local</th>
                                            <th scope="col">Data de publicação</th>
                                            <th scope="col">Descrição física</th>
                                            <th scope="col">Idioma</th>
                                            <th scope="col">Edição</th>
                                            <th scope="col">Usar</th>
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
                                                    record._260c = Z3950Record.pub_date,
                                                    record._260b = Z3950Record.publisher
                                                ">Usar</button>
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
                            <div class="m-3">
                                <label for="doi" class="form-label">DOI</label>
                                <input
                                type="text"
                                class="form-control"
                                v-model="record.doi"
                                id="doi"
                                name="doi"
                                placeholder="DOI"
                                />
                                <button class="btn btn-info btn-sm m-2" @click="getDOI(record.doi), loadingDOI = true">Retrieve DOI data from CrossRef</button>
                            </div>
                        </div>
                        <!-- /DOI -->
                        <!-- LDR -->
                        <div v-show="ldrShow" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <label for="record_status">05 - Record status</label>
                            <select class="form-select" aria-label="Record status" id="record_status" v-model="ldr.record_status">
                                <option value="a">Increase in encoding level</option>
                                <option value="c">Corrected or revised</option>
                                <option value="d">Deleted</option>
                                <option value="n" selected>New</option>
                                <option value="p">Increase in encoding level from prepublication</option>
                            </select>
                            <label for="type_of_record">06 - Type of record</label>
                            <select class="form-select" aria-label="Type of record" id="type_of_record" v-model="ldr.type_of_record">
                                <option value="a" selected>Language material</option>
                                <option value="c">Notated music</option>
                                <option value="d">Manuscript notated music</option>
                                <option value="e">Cartographic material</option>
                                <option value="f">Manuscript cartographic material</option>
                                <option value="g">Projected medium</option>
                                <option value="i">Nonmusical sound recording</option>
                                <option value="j">Musical sound recording</option>
                                <option value="k">Two-dimensional nonprojectable graphic</option>
                                <option value="m">Computer file</option>
                                <option value="o">Kit</option>
                                <option value="p">Mixed materials</option>
                                <option value="r">Three-dimensional artifact or naturally occurring object</option>
                                <option value="t">Manuscript language material</option>
                            </select>
                            <label for="bibliographic_level">07 - Bibliographic level</label>
                            <select class="form-select" aria-label="Bibliographic level" id="bibliographic_level" v-model="ldr.bibliographic_level">
                                <option value="a">Monographic component part</option>
                                <option value="b">Serial component part</option>
                                <option value="c">Collection</option>
                                <option value="d">Subunit</option>
                                <option value="i">Integrating resource</option>
                                <option value="m" selected>Monograph/Item</option>
                                <option value="s">Serial</option>
                            </select>
                            <label for="type_of_control">08 - Type of control</label>
                            <select class="form-select" aria-label="Type of control" id="type_of_control" v-model="ldr.type_of_control">
                                <option value="#" selected>No specified type</option>
                                <option value="a">Archival</option>
                            </select>
                            <label for="character_coding_scheme">09 - Character coding scheme</label>
                            <select class="form-select" aria-label="Character coding scheme" id="character_coding_scheme" v-model="ldr.character_coding_scheme">
                                <option value="#">MARC-8</option>
                                <option value="a" selected>UCS/Unicode</option>
                            </select>
                            <!-- <div class="mb-3">
                                <label for="base_address_of_data" class="form-label">Base address of data (Length of Leader and Directory)</label>
                                <input v-model="base_address_of_data" type="text" class="form-control" id="base_address_of_data">
                            </div> -->
                            <label for="encoding_level">17 - Encoding level</label>
                            <select class="form-select" aria-label="Encoding level" id="encoding_level" v-model="ldr.encoding_level">
                                <option value="#">Full level</option>
                                <option value="1">Full level, material not examined</option>
                                <option value="2">Less-than-full level, material not examined</option>
                                <option value="3">Abbreviated level</option>
                                <option value="4">Core level</option>
                                <option value="5">Partial (preliminary) level</option>
                                <option value="7">Minimal level</option>
                                <option value="8">Prepublication level</option>
                                <option value="u">Unknown</option>
                                <option value="u">Unknown</option>
                                <option value="z">Not applicable</option>
                                <option value="I" selected>Full level cataloging input by OCLC participating library</option>
                                <option value="K">Less-than-full cataloging input by OCLC participating library</option>
                                <option value="L">Non-LC and non-NLM cataloging added from tape</option>
                                <option value="M">Less-than-full cataloging added from tapeloading</option>
                            </select>
                            <label for="descriptive_cataloging_form">18 - Descriptive cataloging form</label>
                            <select class="form-select" aria-label="Descriptive cataloging form" id="descriptive_cataloging_form" v-model="ldr.descriptive_cataloging_form">
                                <option value="#">Non-ISBD</option>
                                <option value="a" selected>AACR 2</option>
                                <option value="c">ISBD punctuation omitted</option>
                                <option value="i">ISBD punctuation included</option>
                                <option value="n">Non-ISBD punctuation omitted</option>
                                <option value="u">Unknown</option>
                            </select>
                            <label for="multipart_resource_record_level">19 - Multipart resource record level</label>
                            <select class="form-select" aria-label="Multipart resource record level" id="multipart_resource_record_level" v-model="ldr.multipart_resource_record_level">
                                <option value="#" selected>Not specified or not applicable</option>
                                <option value="a">Set</option>
                                <option value="b">Part with independent title</option>
                                <option value="c">Part with dependent title</option>
                            </select>
                            <button type="button" class="btn-close" v-on:click="ldrShow = !ldrShow" aria-label="Close"></button>
                        </div>
                        <!-- /LDR -->


                        <br/><br/>

                        <!-- 001 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="_001">Control Number</span>
                            <input type="text" id="_001" v-model="record._001" class="form-control" placeholder="Control Number" aria-label="Control Number" aria-describedby="_001">
                        </div>
                        <!-- \001 -->

                        <!-- 003 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="_003">Control Number Identifier</span>
                            <input type="text" id="_003" v-model="record._003" class="form-control" placeholder="Control Number Identifier" aria-label="Control Number Identifier" aria-describedby="_003">
                        </div>
                        <!-- \003 -->

                        <!-- 040 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="_040">Cataloging Source</span>
                            <input type="text" id="_040a" v-model="record._040a" class="form-control" placeholder="Original cataloging agency" aria-label="Original cataloging agency" aria-describedby="_040a">
                            <input type="text" id="_040c" v-model="record._040c" class="form-control" placeholder="Transcribing agency" aria-label="Transcribing agency" aria-describedby="_040c">
                        </div>
                        <!-- \040 -->

                        <!-- TITLE -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="title">Title</span>
                            <div class="input-group-prepend">
                                <select class="input-group-text form-select" id="_245_ind1" v-model="record._245_ind1">
                                    <option selected>Title added entry</option>
                                    <option value="0">No added entry</option>
                                    <option value="1">Added entry</option>
                                </select>
                            </div>
                            <div class="input-group-prepend">
                                <select class="input-group-text form-select" id="_245_ind2" v-model="record._245_ind2">
                                    <option selected>Nonfiling characters</option>
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
                            <input type="text" id="title" v-model="record.title" class="form-control" aria-label="Title statement" aria-describedby="title">
                        </div>
                        <!-- \TITLE -->
                        <!-- SUBTITLE -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="title">Subtitle</span>
                            <input type="text" id="subtitle" v-model="record.subtitle" class="form-control" aria-label="Subtitle statement" aria-describedby="subtitle">
                        </div>
                        <!-- \SUBTITLE -->

                        <!-- 260 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="title">Imprint</span>
                            <div class="input-group-prepend">
                                <select class="input-group-text form-select" id="_260_ind1" v-model="record._260_ind1">
                                    <option value="#">#</option>
                                </select>
                            </div>
                            <div class="input-group-prepend">
                                <select class="input-group-text form-select" id="_260_ind2" v-model="record._260_ind2">
                                    <option value="#">#</option>
                                </select>
                            </div>
                            <input type="text" id="_260a" v-model="record._260a" class="form-control" placeholder="Place of publication" aria-label="Place of publication" aria-describedby="_260a">
                            <input type="text" id="_260b" v-model="record._260b" class="form-control" placeholder="Name of publisher" aria-label="Name of publisher" aria-describedby="_260b">
                            <input type="text" id="_260c" v-model="record._260c" class="form-control" placeholder="Date of publication" aria-label="Date of publication" aria-describedby="_260c">
                        </div>
                        <!-- \260 -->

                        <!-- 300 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="_300">Physical Description</span>
                            <input type="text" id="_300a" v-model="record._300a" class="form-control" placeholder="Extent (R)" aria-label="Extent (R)" aria-describedby="_300a">
                            <input type="text" id="_300b" v-model="record._300b" class="form-control" placeholder="Other physical details (NR)" aria-label="Other physical details (NR)" aria-describedby="_300b">
                            <input type="text" id="_300c" v-model="record._300c" class="form-control" placeholder="Dimensions (R)" aria-label="Dimensions (R)" aria-describedby="_300c">
                        </div>
                        <!-- \300 -->

                        <h2>Predefined</h2>
                        <button type="button" class="btn btn-primary" @click="ldr.bibliographic_level='m';ldr.type_of_record='a'">Book</button>
                        <button type="button" class="btn btn-info" @click="ldr.bibliographic_level='s';ldr.type_of_record='a'">Serial</button>
                        <button type="button" class="btn btn-success" @click="ldr.bibliographic_level='m';ldr.type_of_record='c'">Musical Score</button>
                    </div>
                    <div class="col-6 col-md-4">
                        <h2>MARC Record</h2>
                        <pre>
                            {{ complete_record }}
                        </pre>
                        <span class="btn btn-info text-white copy-btn ml-auto" @click.stop.prevent="copyTestingCode">Copy</span>
                        <input type="hidden" id="complete_record" :value="complete_record">

                        <div class="alert alert-info" role="alert" v-if="copySuccessful">
                            Copied successful!
                        </div>
                    </div>
                </div>

            </div>

        </main>
        <footer class="footer mt-auto py-3 bg-light">
            <div class="container">
                <span class="text-muted"><a href="https://github.com/trmurakami/online-marc-editor" target="_blank">Online MARC Editor</a> is an Open Source Software created by <a href="https://github.com/trmurakami" target="_blank">Tiago Murakami</a> &middot; 2022</span>
            </div>
        </footer>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>


    <script>
        var app = new Vue({
            el: '#editor',

            data: {                
                ldrShow: false,
                doiShow: false,
                isbnShow: false,
                f008Show: false,
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
                    p18_21: '#',
                    p22: '#',
                    p23: 'r',
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
                    p34: '#'
                },
                crossrefRecord: null,
                ISBNRecord: null,
                Z3950Records: null,
                record: {
                    _001: "",
                    _003: "",
                    _005: "",
                    _040a: "",
                    _040c: "",
                    title: "",
                    _245_ind1: '1',
                    _245_ind2: '0',
                    subtitle: null,
                    doi:null,
                    isbn:null,
                    _260_ind1: "#",
                    _260_ind2: "#",
                    _260a: null,
                    _260b: null,
                    _260c: null,
                    _300_ind1: "#",
                    _300_ind2: "#",
                    _300a: null,
                    _300b: null,
                    _300c: null
                },
                copySuccessful: false,
                current_ldr: null,
                loadingDOI: false,
                loadingISBN: false,
                loadingZ3950: false

            },
            computed: {
                complete_record: function(){
                    return '\n=LDR  ' + this.ldr.record_length + this.ldr.record_status + this.ldr.type_of_record + this.ldr.bibliographic_level + this.ldr.type_of_control + 
                    this.ldr.character_coding_scheme + '22' + this.ldr.base_address_of_data + this.ldr.encoding_level + this.ldr.descriptive_cataloging_form + 
                    this.ldr.multipart_resource_record_level + '4500' +
                    '\n=001  ' + this.record._001 +
                    '\n=003  ' + this.record._003 +
                    '\n=005  ' + this.record._005 +
                    '\n=008  ' + this.f008.p00_05 + this.f008.p06 + this.f008.p07_10 + this.f008.p11_14 + this.f008.p15_17 + this.f008.p18_21 + this.f008.p22 + this.f008.p23 +
                    this.f008.p24 + this.f008.p25 + this.f008.p26 + this.f008.p27 + this.f008.p28 + this.f008.p29 + this.f008.p30 + this.f008.p31 + this.f008.p32 +
                    this.f008.p33 + this.f008.p34 +
                    (this.record.isbn ? '\n=020  ##$a' + this.record.isbn : '') +
                    (this.record.doi ? '\n=024  70$a' + this.record.doi + '$2doi': '') +
                    '\n=040  ##' + '$a' + this.record._040a + '$c' + this.record._040c +
                    '\n=245  ' + this.record._245_ind1 + this.record._245_ind2 + '$a' + this.record.title +
                    (this.record.subtitle ? '$b' + this.record.subtitle : '') +
                    '\n=260  ' + this.record._260_ind1 + this.record._260_ind2 + (this.record._260a ? '$a' + this.record._260a : '') + 
                    (this.record._260b ? '$b' + this.record._260b : '') + (this.record._260c ? '$c' + this.record._260c : '') +
                    '\n=300  ' + this.record._300_ind1 + this.record._300_ind2 + (this.record._300a ? '$a' + this.record._300a : '') + 
                    (this.record._300b ? '$b' + this.record._300b : '') + (this.record._300c ? '$c' + this.record._300c : '')
                }
            },
            mounted() {
                this.update005()
            },
            methods: {
                copyTestingCode () {
                    let testingCodeToCopy = document.querySelector('#complete_record')
                    testingCodeToCopy.setAttribute('type', 'text')
                    testingCodeToCopy.select()

                    try {
                        var successful = document.execCommand('copy');
                        var msg = successful ? 'successful' : 'unsuccessful';
                        this.copySuccessful = true
                        setTimeout(() => {   this.copySuccessful = false; }, 2000);
                    } catch (err) {
                        alert('Oops, unable to copy');
                    }

                    /* unselect the range */
                    testingCodeToCopy.setAttribute('type', 'hidden')
                    window.getSelection().removeAllRanges()
                },
                getDOI(doi) {
                    axios
                        .get("https://api.crossref.org/works/" + doi)
                        .then((response) => {
                        this.crossrefRecord = response,
                        this.record.title = this.crossrefRecord.data.message.title,
                        // this.record.url = this.crossrefRecord.data.message.URL,
                        this.record._260b = this.crossrefRecord.data.message.publisher,
                        this.record._260c = this.crossrefRecord.data.message.issued['date-parts'][0][0]
                        // Object.values(this.crossrefRecord.data.message.author).forEach(val => {
                        //     this.record.author.push({ id: "", name: val.given + " " + val.family, function: "Author" });
                        // });
                        // if (this.crossrefRecord.data.message.ISBN) {
                        //     this.record.isbn[0].id = this.crossrefRecord.data.message.ISBN.[0]
                        // }
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
                        this.record._260c = this.ISBNRecord.items[0].volumeInfo.publishedDate
                        //this.record.numberOfPages = this.ISBNRecord.items.[0].volumeInfo.pageCount
                        //Object.values(this.ISBNRecord.items.[0].volumeInfo.authors).forEach(val => {
                        //    this.record.author.push({ id: "", name: val, function: "" });
                        //});
                        })
                        .catch(function (error) {
                        console.log(error);
                        this.errored = true;
                        })
                        .finally(() => (this.loadingISBN = false));
                },
                getZ3950(isbn, host, hostname) {
                    axios
                    .get("http://34.134.188.198/api/z3950?isbn=" + isbn + '&host=' + host)
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
                update005() {
                    let today = new Date().toISOString().replace('-', '').replace('-', '').replace('T', '').replace(':', '').replace(':', '').substr(0,16);
                    this.record._005 = today
                }
            }
        })
    </script>        
  </body>
</html>