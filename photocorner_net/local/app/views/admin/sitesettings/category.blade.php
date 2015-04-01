@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-wrench"></i></small>
            Podešavanje Kategorija
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-10">

        {{ Form::open() }}
        <div class="form-group">
            <label for="addnew">Dodaj novu Kategoriju</label>
            {{ Form::text('addnew','',array('class'=>'form-control','placeholder'=>'Name of category')) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Add new category',array('class'=>'btn btn-success')) }}
        </div>
        {{ Form::close() }}


        <div class="page-header">
            <h3 class="content-heading">Trenutne Kategorije
                <small>Možete napraviti broj kategorija po želji, i izmeniti raspored Pomeranjem jedne ispod druge.</small>
            </h3>
        </div>

        <div class='area' id='adminChannels'>

            <ol class='sortable list channelList list-group'>

                <?php

                // Output the channels list as nested <ol>s so the order and structure can be manipluated.
                $curDepth = 0;
                $counter = 0;

                // For each of the channels...
                foreach (Category::orderBy('lft', 'asc')->get() as $category):

                // If this channel is on the same depth as the last channel, just end the previous channel's <li>.
                if ($category->depth == $curDepth)
                {
                    if ($counter > 0) echo "</li>";
                }
// If this channel is deeper than the last channel, start a new <ol>.
                elseif ($category->depth > $curDepth)
                {
                    echo "<ol>";
                    $curDepth = $category->depth;
                }
// If this channel is shallower than the last channel, end <li> and <ol> tags as necessary.
                elseif ($category->depth < $curDepth)
                {
                    echo str_repeat("</li></ol>", $curDepth - $category->depth), "</li>";
                    $curDepth = $category->depth;
                }

                // Output a list item for this channel.
                ?>
                <li id='channel_{{ $category->id }}' data-id='{{ $category->id }}' class="list-group-item mjs-nestedSortable-no-nesting" style="cursor: move">
                    <i class="fa fa-arrows-alt pull-left">&nbsp;</i>
                    <a href="" class="pull-right" data-toggle="modal" data-target="#categoryMode-{{ $category->id }}"><i class="fa fa-edit pull-right" data-toggle="tooltip" data-placement="top" data-original-title="Click to edit this category"></i></a>

                    <div class='info'>
                        <span class='channel channel-1'>{{ $category->name }}</span>
                    </div>

                    <?php $counter++; ?>

                    <?php endforeach;

                    // End as many unclosed <li> and <ol> tags as necessary.
                    echo str_repeat("</li></ol>", $curDepth), "</li>";
                    ?>
            </ol>
        </div>
    </div>

    @foreach (Category::orderBy('lft','asc')->get() as $category)
    <div class="modal fade" id="categoryMode-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Izmenjivanje Kategorije</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url'=>'admin/sitecategory/update')) }}
                    <div class="form-group">
                        {{ Form::text('id',$category->id,array('class'=>'hidden')) }}
                        <label for="addnew">Naziv Kategorije</label>
                        {{ Form::text('name',$category->name,array('class'=>'form-control','placeholder'=>'Name of category','required'=>'required')) }}
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug ( url of category )
                            <small>Samo Engleski karakteri su dozvoljeni zbog url-a</small>
                        </label>
                        {{ Form::text('slug',$category->slug,array('class'=>'form-control','placeholder'=>'Slug','required'=>'required')) }}
                    </div>
                    @if($category->id == 1 || $category->name == 'Uncategorized')
                        <p>Ovu kategoriju nije moguće obrisati, zato što slike koje nisu kategorisanu pripadaju ovoj kategoriji</p>
                    @else
                    <div class="form-group">
                        <label for="addnew">Obriši ovu Kategoriju
                            <small> (  )</small>
                        </label><br/>
                        {{ Form::checkbox('delete',TRUE,FALSE,array('rel' => 'delete')) }}
                    </div>
                    @endif
                    <div class="form-group">
                        <p><strong>Premesti Fotografije iz ove kategorije u drugu</strong></p>
                        <select name="shiftCategory" class="form-control" disabled rel="shiftToCategory">
                            @foreach(Category::whereNotIn('id', array($category->id))->orderBy('lft','asc')->get() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                        {{ Form::submit('Update',array('class'=>'btn btn-success')) }}
                        {{ Form::close() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @endforeach


    @stop

    @section('extra-js')
    <script type="text/javascript">

        $(function () {
            $("[rel=delete]").click(function () {
                $("[rel=shiftToCategory]").attr("disabled", false);
            });
        });

        $("#adminChannels .channelList").nestedSortable({
            forcePlaceholderSize: true,
            disableNestingClass: 'mjs-nestedSortable-no-nesting',
            handle: 'div',
            helper: 'clone',
            items: 'li',
            maxLevels: 0,
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            update: function () {
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/sitecategory/reorder') }}",
                    data: {tree: $("#adminChannels .channelList").nestedSortable("toArray", {startDepthCount: -1})},
                    globalLoading: true
                });
            }
        });

    </script>
    @stop