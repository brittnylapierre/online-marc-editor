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
    <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->

    <title>Online MARC Editor</title>
  </head>
  <body>
        <header class="p-5 pb-0">
            <h1>Online MARC Editor</h1>
            <p>An online editor to create MARC records</p>
        </header>
        <main>
            <div id="editor">

                <div class="row">
                    <div class="col-md-8 p-5 pt-2" >
                        <button v-on:click="ldrShow = !ldrShow" type="button" class="btn btn-primary">LDR</button>
                        <div v-show="ldrShow" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <label for="record_status">Record status</label>
                            <select class="form-select" aria-label="Record status" id="record_status" v-model="ldr.record_status">
                                <option value="a">Increase in encoding level</option>
                                <option value="c">Corrected or revised</option>
                                <option value="d">Deleted</option>
                                <option value="n" selected>New</option>
                                <option value="p">Increase in encoding level from prepublication</option>
                            </select>
                            <label for="type_of_record">Type of record</label>
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
                            <label for="bibliographic_level">Bibliographic level</label>
                            <select class="form-select" aria-label="Bibliographic level" id="bibliographic_level" v-model="ldr.bibliographic_level">
                                <option value="a">Monographic component part</option>
                                <option value="b">Serial component part</option>
                                <option value="c">Collection</option>
                                <option value="d">Subunit</option>
                                <option value="i">Integrating resource</option>
                                <option value="m" selected>Monograph/Item</option>
                                <option value="s">Serial</option>
                            </select>
                            <label for="type_of_control">Type of control</label>
                            <select class="form-select" aria-label="Type of control" id="type_of_control" v-model="ldr.type_of_control">
                                <option value="\" selected>No specified type</option>
                                <option value="a">Archival</option>
                            </select>
                            <label for="character_coding_scheme">Character coding scheme</label>
                            <select class="form-select" aria-label="Character coding scheme" id="character_coding_scheme" v-model="ldr.character_coding_scheme">
                                <option value="\">MARC-8</option>
                                <option value="a" selected>UCS/Unicode</option>
                            </select>
                            <!-- <div class="mb-3">
                                <label for="base_address_of_data" class="form-label">Base address of data (Length of Leader and Directory)</label>
                                <input v-model="base_address_of_data" type="text" class="form-control" id="base_address_of_data">
                            </div> -->
                            <label for="encoding_level">Encoding level</label>
                            <select class="form-select" aria-label="Encoding level" id="encoding_level" v-model="ldr.encoding_level">
                                <option value="\">Full level</option>
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
                            <label for="descriptive_cataloging_form">Descriptive cataloging form</label>
                            <select class="form-select" aria-label="Descriptive cataloging form" id="descriptive_cataloging_form" v-model="ldr.descriptive_cataloging_form">
                                <option value="\">Non-ISBD</option>
                                <option value="a" selected>AACR 2</option>
                                <option value="c">ISBD punctuation omitted</option>
                                <option value="i">ISBD punctuation included</option>
                                <option value="n">Non-ISBD punctuation omitted</option>
                                <option value="u">Unknown</option>
                            </select>
                            <label for="multipart_resource_record_level">Multipart resource record level</label>
                            <select class="form-select" aria-label="Multipart resource record level" id="multipart_resource_record_level" v-model="ldr.multipart_resource_record_level">
                                <option value="\" selected>Not specified or not applicable</option>
                                <option value="a">Set</option>
                                <option value="b">Part with independent title</option>
                                <option value="c">Part with dependent title</option>
                            </select>
                            <button type="button" class="btn-close" v-on:click="ldrShow = !ldrShow" aria-label="Close"></button>
                        </div>


                        <br/><br/>

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


                        <h2>Predefined</h2>
                        <button type="button" class="btn btn-primary" @click="bibliographic_level='m';type_of_record='a'">Book</button>
                        <button type="button" class="btn btn-info" @click="bibliographic_level='s';type_of_record='a'">Serial</button>
                        <button type="button" class="btn btn-success" @click="bibliographic_level='m';type_of_record='c'">Score Music</button>
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

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        var app = new Vue({
            el: '#editor',

            data: {                
                ldrShow: false,
                ldr:{
                    record_length: '00000',
                    record_status: 'n',
                    type_of_record: 'a',
                    bibliographic_level: 'm',
                    type_of_control: "\\",
                    character_coding_scheme: "a",
                    encoding_level: "I",
                    descriptive_cataloging_form: "a",
                    multipart_resource_record_level: "\\"
                },
                record: {
                    title: "",
                    _245_ind1: '1',
                    _245_ind2: '0'
                },
                copySuccessful: false,
                current_ldr: null,

            },
            computed: {
                base_address_of_data: function(){
                    return this.current_ldr
                    ? this.current_ldr.substring(12,17)
                    : '00000'
                },
                complete_record: function(){
                    return '\n=LDR  ' + this.ldr.record_length + this.ldr.record_status + this.ldr.type_of_record + this.ldr.bibliographic_level + this.ldr.type_of_control + 
                    this.ldr.character_coding_scheme + '22' + this.ldr.base_address_of_data + this.ldr.encoding_level + this.ldr.descriptive_cataloging_form + 
                    this.ldr.multipart_resource_record_level + '4500' + 
                    '\n=245  ' + this.record._245_ind1 + this.record._245_ind2 + '$a' + this.record.title
                }
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
            }
        })
    </script>
        
  </body>
</html>