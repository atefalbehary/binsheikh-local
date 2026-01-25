@if ($paginator->hasPages())
<div class="pagination">
       
        @if ($paginator->onFirstPage())
            <a href="#" class="prevposts-link previous disabled"><i class="fa fa-caret-left"></i></a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="prevposts-link"><i class="fa fa-caret-left"></i></a>
        @endif

        <?php 
        $apString = "";
        if(!empty($_GET)) { 
            
            foreach ($_GET as $key => $value) {
                $apString .= "&".$key."=".$value; 
            }
        }
        
        ?>
      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled" style="margin-top: 12px"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="current-page" ata-dt-idx="{{ $page }}">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}"  data-dt-idx="{{ $page }}" >{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="nextposts-link"><i class="fa fa-caret-right"></i></a>
        @else
            <a href="#" class="nextposts-link disabled"><i class="fa fa-caret-right"></i></a>
        @endif
    </div>
@endif 