<aside class="card pad w-full md:w-72">
  <div class="font-semibold text-lg mb-3">Kategori Obat</div>
  <div class="space-y-2">
    @foreach($groups as $g)
      <details {{ (isset($activeCategory) && ($activeCategory->id === $g->id || $activeCategory->parent_id === $g->id)) ? 'open' : '' }}>
        <summary class="cursor-pointer px-2 py-2 rounded-lg hover:bg-brand-50 font-medium">{{ $g->name }}</summary>
        <nav class="mt-1 ml-3 flex flex-col">
          <a href="{{ route('shop.index', array_filter(['category'=>$g->slug,'q'=>request('q')])) }}"
             class="py-1 text-sm {{ request('category')===$g->slug ? 'text-brand-700 font-semibold' : 'text-gray-700 hover:text-brand-700' }}">Semua di {{ $g->name }}</a>
          @foreach($g->children as $child)
            <a href="{{ route('shop.index', array_filter(['category'=>$child->slug,'q'=>request('q')])) }}"
               class="py-1 text-sm {{ request('category')===$child->slug ? 'text-brand-700 font-semibold' : 'text-gray-700 hover:text-brand-700' }}">{{ $child->name }}</a>
          @endforeach
        </nav>
      </details>
    @endforeach
  </div>
</aside>
