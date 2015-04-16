<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"></td>
        <td class="size"></span></td>
        {% if (file.type == 'error') { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=file.msg || locale.fileupload.errors[file.error]%}</td>
        {% } else if (file.type == 'info') { %}
            <td class="info" colspan="2"><span class="label label-info">Info</span> {%=file.msg %}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>Akármi
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=file.msg || locale.fileupload.errors[file.error]%}</td>
        {% } %}
        <td class="cancel">{% if (!i) { %}

        {% } %}</td>
    </tr>
{% } %}
</script>
