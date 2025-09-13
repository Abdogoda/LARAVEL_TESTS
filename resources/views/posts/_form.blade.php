<!-- Title -->
<div class="mb-6 group/field">
    <label style="display: flex" for="title" class="text-sm font-medium text-emerald-300 mb-3 flex items-center group-hover/field:text-emerald-200 transition-colors duration-200">
        <div class="w-5 h-5 bg-gradient-to-r from-emerald-400 to-green-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
        </div>
        Title
    </label>
    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}"
           placeholder="Enter post title..."
           class="block w-full bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm py-3 px-4 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400/50 focus:border-emerald-400/50 hover:bg-white/15 transition-all duration-200 @error('title') border-red-400/50 @else border-white/20 @enderror">
    @error('title')
        <p class="mt-2 text-sm text-red-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>

<!-- Category -->
<div class="mb-6 group/field">
    <label style="display: flex" for="category_id" class="text-sm font-medium text-teal-300 mb-3 flex items-center group-hover/field:text-teal-200 transition-colors duration-200">
        <div class="w-5 h-5 bg-gradient-to-r from-teal-400 to-cyan-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4H5m4 8H5" />
            </svg>
        </div>
        Category
    </label>
    <select name="category_id" id="category_id" class="block w-full bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm py-3 px-4 focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400/50 hover:bg-white/15 transition-all duration-200 @error('category_id') border-red-400/50 @else border-white/20 @enderror">
        <option value="">Select a category...</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" 
                    {{ (old('category_id', $post->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="mt-2 text-sm text-red-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>

<!-- Image Upload -->
<div class="mb-6 group/field">
    <label style="display: flex" for="image" class="text-sm font-medium text-purple-300 mb-3 flex items-center group-hover/field:text-purple-200 transition-colors duration-200">
        <div class="w-5 h-5 bg-gradient-to-r from-purple-400 to-pink-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        Featured Image (Optional)
    </label>
    <input type="file" 
           name="image" 
           id="image" 
           accept="image/*"
           class="block w-full bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm py-3 px-4 focus:ring-2 focus:ring-purple-400/50 focus:border-purple-400/50 hover:bg-white/15 transition-all duration-200 @error('image') border-red-400/50 @else border-white/20 @enderror
           file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium
           file:bg-purple-500/20 file:text-purple-300 hover:file:bg-purple-500/30">
    @error('image')
        <p class="mt-2 text-sm text-red-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $message }}
        </p>
    @enderror
    @if(isset($post) && $post->image)
        <div class="mt-3 p-3 bg-white/5 rounded-lg border border-white/10">
            <p class="text-sm text-gray-400 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-1 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Current Image:
            </p>
            <img src="{{ Storage::url($post->image) }}" alt="Current post image" class="w-32 h-20 object-cover rounded-lg border border-white/20">
        </div>
    @endif
    <p class="mt-2 text-sm text-gray-400 flex items-center">
        <svg class="w-4 h-4 mr-1 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Upload a featured image for your post (JPG, PNG, GIF - Max: 2MB).
    </p>
</div>

<!-- Content -->
<div class="mb-6 group/field">
    <label style="display: flex" for="content" class="text-sm font-medium text-cyan-300 mb-3 flex items-center group-hover/field:text-cyan-200 transition-colors duration-200">
        <div class="w-5 h-5 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        Content
    </label>
    <textarea name="content" id="content" rows="10" placeholder="Write your post content here..."
        class="block w-full bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm py-3 px-4 placeholder-gray-300 focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/50 hover:bg-white/15 transition-all duration-200 @error('content') border-red-400/50 @else border-white/20 @enderror"
    >{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')
        <p class="mt-2 text-sm text-red-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $message }}
        </p>
    @enderror
    <p class="mt-2 text-sm text-gray-400 flex items-center">
        <svg class="w-4 h-4 mr-1 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Write your post content in plain text or Markdown.
    </p>
</div>

<!-- Published Date -->
<div class="mb-6 group/field">
    <label style="display: flex" for="published_at" class="text-sm font-medium text-indigo-300 mb-3 flex items-center group-hover/field:text-indigo-200 transition-colors duration-200">
        <div class="w-5 h-5 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        Published Date (Optional)
    </label>
    <input type="datetime-local" 
           name="published_at" 
           id="published_at" 
           value="{{ old('published_at', optional($post->published_at ?? null)->format('Y-m-d\TH:i')) }}"
           class="block w-full bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm py-3 px-4 focus:ring-2 focus:ring-indigo-400/50 focus:border-indigo-400/50 hover:bg-white/15 transition-all duration-200 @error('published_at') border-red-400/50 @else border-white/20 @enderror">
    @error('published_at')
        <p class="mt-2 text-sm text-red-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $message }}
        </p>
    @enderror
    <p class="mt-2 text-sm text-gray-400 flex items-center">
        <svg class="w-4 h-4 mr-1 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Leave empty to save as draft. Set a future date to schedule publication.
    </p>
</div>

<!-- Form Actions -->
<div class="flex items-center justify-between pt-6 border-t border-gray-700">
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Cancel
    </a>
    
    <div class="flex items-center space-x-3">
        @if(isset($post) && $post->exists)
            <!-- Update Post Button -->
            <button type="submit" name="action" value="publish" class="btn btn-primary">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Update Post
            </button>
            @if ($post->status == 'draft')
                <button type="submit" name="action" value="publish" class="btn btn-secondary">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Publish
                </button>
            @endif
        @else
            <!-- Save as Draft Button (for new posts) -->
            <button type="submit" name="action" value="draft" class="btn btn-secondary">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Save as Draft
            </button>
            
            <!-- Publish Post Button -->
            <button type="submit" name="action" value="publish" class="btn btn-primary">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Publish Post
            </button>
        @endif
    </div>
</div>