<script>
    import marked from 'marked'

    export let file = 'example.md'
    console.log('file', file)

    let someHtml = ''

    fetch('./md/'+file)
        .then(response => response.text())
        .then(text => {
            someHtml = marked(text)
        })
</script>

{@html someHtml}
