<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="site">Site</label>
                    <input id="site" type="text" class="form-control" v-model="site" disabled>
                </div>

                <div class="form-group">
                    <label for="pages">Pages</label>
                    <select id="pages" class="form-control" v-model="pages">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <small id="emailHelp" class="form-text text-muted">How many pages to scrape.</small>
                </div>

                <button type="submit" v-bind:class="{ disabled: loading }" class="btn btn-primary" @click="scrapeSite">Scrape</button>

                <div v-if="results">
                    <hr>
                    <div v-for="accountant in results">
                        <ul>
                            <li v-for="(attributes, label) in accountant">{{ label }} : {{ attributes }} </li>
                        </ul>
                        <hr>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "Scraper",
        data() {
          return {
              site: 'https://www.icas.com/find-a-ca',
              pages: 1,
              results: null,
              loading: false
          }
        },
        methods: {
            scrapeSite() {
                this.loading = true;
                axios.post('/api/scrape', {
                    site: this.site,
                    pages: this.pages
                }).then(response => {
                    this.results = response.data;

                    this.loading = false;
                }).catch(error => {

                })
            }
        }
    }
</script>

<style scoped>
.card {
    width: 480px;
    margin-left: auto;
    margin-right: auto;
}
</style>