var options = {
    filebrowserImageBrowseUrl: '/filemanager?type=Images',
    filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/filemanager?type=Files',
    filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
};
// CKEDITOR.config.height = 250;
function ckeditor(id, height) {
    CKEDITOR.replace(id, options);
    CKEDITOR.config.height = height;
};
// CKEDITOR.replace('description', options);

CKEDITOR.config.colorButton_colors = 'CF5D4E,454545,FFF,CCC,DDD,CCEAEE,66AB16';
CKEDITOR.config.colorButton_enableMore = true;
CKEDITOR.config.floatpanel = true;
CKEDITOR.config.floatpanel = true;
CKEDITOR.config.toolbarGroups = [
    { name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
    { name: 'clipboard', groups: ['clipboard', 'undo'] },
    { name: 'document', groups: ['mode', 'document', 'doctools'] },
    { name: 'forms', groups: ['forms'] },
    { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
    { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph'] },
    { name: 'links', groups: ['links'] },
    { name: 'insert', groups: ['insert'] },
    { name: 'styles', groups: ['styles'] },
    { name: 'colors', groups: ['colors'] },
    { name: 'tools', groups: ['tools'] },
    { name: 'others', groups: ['others'] },
    { name: 'about', groups: ['about'] }
];

CKEDITOR.config.removeButtons = 'Source,Save,Templates,Find,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Outdent,Indent,CreateDiv,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,BidiLtr,BidiRtl,Language,Unlink,Anchor,Image,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,ShowBlocks,About,Print,PasteFromWord,PasteText,Paste,Copy,Cut,Replace,Link';