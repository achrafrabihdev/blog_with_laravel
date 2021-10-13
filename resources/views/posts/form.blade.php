<div class="mb-3 form-group">
    <label for="title" class="col-form-label">Title</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="Entrez un titre" value="{{old('title',$post->title ?? null)}}">
</div>
<div class="mb-3 form group">
    <label for="content" class="col-form-label">Content</label>
    <input type="text" class="form-control" id="content" name="content" placeholder="Entrez un contenu" value="{{old('content',$post->content ?? null)}}">
</div>
<div class="mb-3 form-group">
    <label for="picture"></label>
    <input type="file" name="picture" id="picture" class="form-control-file">
</div>
<x-errors my-class="danger"></x-errors>
