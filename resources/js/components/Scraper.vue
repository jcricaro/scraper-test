<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="site">Site</label>
                    <input id="site" type="text" class="form-control" value="https://www.icas.com/find-a-ca" disabled>
                </div>

                <div class="form-group">
                    <label for="pages">Pages</label>
                    <select id="pages" class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <small id="emailHelp" class="form-text text-muted">How many pages to scrape.</small>
                </div>

                <button type="submit" class="btn btn-primary">Scrape</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Scraper"
    }
</script>

<style scoped>
.card {
    width: 480px;
    margin-left: auto;
    margin-right: auto;
}
</style>