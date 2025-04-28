<div class="mx-20 mt-4">
    <?php if (empty($posts)): ?>
        <p class="text-gray-600 text-center py-8">
            <?php echo 'No posts found'; ?>
        </p>
    <?php else: ?>
        <?php if ($post_id && !empty($posts)): ?>
            <!-- Single Post View -->
            <?php $post = $posts[0]; ?>
            <article class="bg-white dark:bg-[#0e1113] rounded-lg shadow-sm p-4">
                <header class="flex justify-between items-start">    
                    <!-- Post Content -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <img src="<?php echo htmlspecialchars($post['avatar_path'] ?? '/default-avatar.png'); ?>" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                            <span class="text-sm text-[#abc1ca]"><?php echo htmlspecialchars($post['username']); ?> • <?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></span>
                        </div>
                        <h1 class="text-2xl font-bold dark:text-white mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
                        <p class="dark:text-white mb-4"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <?php if (!empty($post['image_path'])): ?>
                            <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post image" class="rounded-lg mb-4 max-w-full">
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['user_id']) && $post['user_id'] == $_SESSION['user_id'] || isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <div>
                            <button data-popover-target="popover-bottom" data-popover-trigger="click" data-popover-placement="bottom" type="button" class="text-white bg-transparent hover:bg-blue-800 font-medium rounded-full p-1 text-sm text-center dark:hover:bg-[#2a3236]">
                                <?php include "public/icons/dots-horizontal.svg"; ?>
                            </button>
                            <div data-popover id="popover-bottom" role="tooltip" class="absolute z-10 invisible w-30 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-[#181c1f]">
                                <a href="/reddit/post/edit/<?php echo $post['post_id']; ?>">
                                    <div class="flex items-center w-full px-4 py-2 rounded-t-lg font-medium text-left rtl:text-right cursor-pointer hover:bg-gray-100 hover:text-blue-700 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <?php include "public/icons/pencil-outline.svg"; ?>
                                        Edit post
                                    </div>
                                </a>
                                <a href="/reddit/post/delete/<?php echo $post['post_id']; ?>" onclick="return confirm('Are you sure you want to delete this post?')" type="button">
                                    <div class="flex items-center w-full px-4 py-2 rounded-b-lg font-medium text-left rtl:text-right cursor-pointer hover:bg-gray-100 hover:text-blue-700 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <?php include "public/icons/delete-outline.svg"; ?>
                                        Delete
                                    </div> 
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </header>
                <!-- Voting -->
                <div class="flex items-center pt-1 bg-[#2a3236] w-fit rounded-2xl px-1 vote-section transition-colors" data-post-id="<?php echo $post['post_id']; ?>">
                    <form action="/reddit/vote" method="POST" class="vote-form" data-post-id="<?php echo $post['post_id']; ?>" data-vote-type="up">
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                        <input type="hidden" name="vote_type" value="up">
                        <button type="submit" class="text-[#abc1ca] rounded-xl" onclick="event.stopPropagation();" <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>
                            <?php include "public/icons/upvote-outline.svg"; ?>   
                        </button>
                    </form>
                    <span class="text-sm text-center font-bold text-white p-1 mb-1 vote-count-<?php echo $post['post_id']; ?>"><?php echo $post['upvotes'] - $post['downvotes']; ?></span>
                    <form action="/reddit/vote" method="POST" class="vote-form" data-post-id="<?php echo $post['post_id']; ?>" data-vote-type="down">
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                        <input type="hidden" name="vote_type" value="down">
                        <button type="submit" class="text-[#abc1ca] rounded-xl" onclick="event.stopPropagation();" <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>
                            <?php include "public/icons/downvote-outline.svg"; ?>                          
                        </button>
                    </form>
                </div>
                <section class="mt-6">
                    <h3 class="text-lg font-semibold dark:text-white mb-4">Comments</h3>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form action="/reddit/comment" method="POST" class="mb-6">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <textarea name="content" class="w-full p-2 rounded-lg dark:bg-[#181c1f] dark:text-white border border-gray-200 dark:border-gray-600" rows="3" placeholder="Add a comment..." required></textarea>
                            <button type="submit" class="text-white bg-blue-7 hover:bg-blue-800 font-medium rounded-3xl text-sm px-4 py-2 md:px-4 md:py-3 dark:bg-[#115bca] dark:hover:bg-[#ae2c00]">Submit</button>
                        </form>
                    <?php endif; ?>

                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="border-t dark:border-gray-600 pt-4 mt-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <img src="<?php echo htmlspecialchars($comment['avatar_path'] ?? '/default-avatar.png'); ?>" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                                            <span class="text-sm text-[#abc1ca]"><?php echo htmlspecialchars($comment['username']); ?> • <?php echo date('F j, Y, g:i a', strtotime($comment['created_at'])); ?></span>
                                        </div>
                                        <p class="dark:text-white comment-content-<?php echo $comment['comment_id']; ?>"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                                        
                                        <!-- Edit Form (hidden by default) -->
                                        <?php if (isset($_SESSION['user_id']) && $comment['user_id'] == $_SESSION['user_id'] || isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                            <form action="/reddit/comment/edit" method="POST" class="hidden mt-2 edit-form-<?php echo $comment['comment_id']; ?>">
                                                <input type="hidden" name="action" value="edit">
                                                <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                                <textarea name="content" class="w-full p-2 rounded-lg dark:bg-[#181c1f] dark:text-white border border-gray-200 dark:border-gray-600" rows="3" required><?php echo htmlspecialchars($comment['content']); ?></textarea>
                                                <div class="mt-2">
                                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-3xl text-sm px-3 py-1 dark:bg-[#115bca] dark:hover:bg-[#ae2c00]">Save</button>
                                                    <button type="button" onclick="toggleEditForm(<?php echo $comment['comment_id']; ?>)" class="text-gray-500 hover:text-gray-700 font-medium rounded-3xl text-sm px-3 py-1">Cancel</button>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (isset($_SESSION['user_id']) && $comment['user_id'] == $_SESSION['user_id'] || isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                        <div class="flex gap-2">
                                            <button onclick="toggleEditForm(<?php echo $comment['comment_id']; ?>)" class="text-gray-500 hover:text-blue-600">
                                                <?php include "public/icons/edit-comment.svg"; ?>
                                            </button>
                                            <a href="/reddit/comment/delete/<?php echo $comment['comment_id']; ?>" onclick="return confirm('Are you sure you want to delete this comment?')" class="text-gray-500 hover:text-red-600">
                                                <?php include "public/icons/delete-comment.svg" ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-600 dark:text-gray-400">No comments yet.</p>
                    <?php endif; ?>
                </section>
            </article>
        <?php else: ?>
            <!-- Posts List -->
            <div class="space-y-2">
                <?php foreach ($posts as $post): ?>
                    <div class="border-t-[1px] border-[#383b3c]" />
                    <a href="/reddit/post/<?php echo $post['post_id']; ?>" class="block my-1">
                        <article class="bg-white dark:bg-[#0e1113] rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-[#181c1f] p-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <img src="<?php echo htmlspecialchars($post['avatar_path'] ?? '/default-avatar.png'); ?>" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm text-[#abc1ca]"><?php echo htmlspecialchars($post['username']); ?> • <?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></span>
                                </div>
                                <h2 class="text-xl font-semibold dark:text-white mb-3"><?php echo htmlspecialchars($post['title']); ?></h2>
                                <p class="dark:text-white mb-3"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                                <?php if (!empty($post['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post image" class="rounded-lg mb-3 max-w-full">
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center pt-1 bg-[#2a3236] w-fit rounded-2xl px-1 vote-section transition-colors" data-post-id="<?php echo $post['post_id']; ?>">
                                <form action="/reddit/vote" method="POST" class="vote-form" data-post-id="<?php echo $post['post_id']; ?>" data-vote-type="up">
                                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                                    <input type="hidden" name="vote_type" value="up">
                                    <button type="submit" class="text-[#abc1ca] rounded-xl" onclick="event.stopPropagation();" <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>
                                        <?php include "public/icons/upvote-outline.svg"; ?>   
                                    </button>
                                </form>
                                <span class="text-sm text-center font-bold text-white p-1 mb-1 vote-count-<?php echo $post['post_id']; ?>"><?php echo $post['upvotes'] - $post['downvotes']; ?></span>
                                <form action="/reddit/vote" method="POST" class="vote-form" data-post-id="<?php echo $post['post_id']; ?>" data-vote-type="down">
                                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                                    <input type="hidden" name="vote_type" value="down">
                                    <button type="submit" class="text-[#abc1ca] rounded-xl" onclick="event.stopPropagation();" <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>
                                        <?php include "public/icons/downvote-outline.svg"; ?> 
                                    </button>
                                </form>
                            </div>
                        </article>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.vote-form').forEach(form => {
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();

        const postId = this.dataset.postId;
        const voteType = this.dataset.voteType;
        const voteSection = this.closest('.vote-section');
        const voteCountElement = voteSection.querySelector(`.vote-count-${postId}`);
        const upvoteSvg = voteSection.querySelector('.upvote-svg');
        const downvoteSvg = voteSection.querySelector('.downvote-svg');
        const isSelected = voteSection.dataset.vote === voteType;
        const formData = new FormData(this);

        if (isSelected) {
            formData.append('remove_vote', 'true');
        }


        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                voteCountElement.textContent = data.new_count;
                if (isSelected) {
                    voteSection.classList.remove('bg-orange-600', 'bg-purple-600');
                    voteSection.classList.add('bg-[#2a3236]');
                    upvoteSvg.setAttribute('fill', '#abc1ca');
                    downvoteSvg.setAttribute('fill', '#abc1ca');
                    voteSection.dataset.vote = '';
                } else {
                    voteSection.classList.remove('bg-orange-600', 'bg-purple-600', 'bg-[#2a3236]');
                    voteSection.classList.add(voteType === 'up' ? 'bg-orange-600' : 'bg-purple-600');
                    if (voteType === 'up') {
                        upvoteSvg.setAttribute('fill', 'white');
                        downvoteSvg.setAttribute('fill', '#abc1ca');
                    } else {
                        downvoteSvg.setAttribute('fill', 'white');
                        upvoteSvg.setAttribute('fill', '#abc1ca');
                    }
                    voteSection.dataset.vote = voteType;
                }
            } else {
                console.error('Vote failed:', data.error);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    });
});

// Load initial vote state
document.querySelectorAll('.vote-section').forEach(section => {
    const postId = section.dataset.postId;
    fetch(`/reddit/vote/status/${postId}`, {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        section.classList.remove('bg-orange-600', 'bg-purple-600');
        const upvoteSvg = section.querySelector('.upvote-svg');
        const downvoteSvg = section.querySelector('.downvote-svg');
        if (data.user_vote === 'up') {
            section.classList.add('bg-orange-600');
            upvoteSvg.setAttribute('fill', 'white');
            downvoteSvg.setAttribute('fill', '#abc1ca');
            section.dataset.vote = 'up';
        } else if (data.user_vote === 'down') {
            section.classList.add('bg-purple-600');
            downvoteSvg.setAttribute('fill', 'white');
            upvoteSvg.setAttribute('fill', '#abc1ca');
            section.dataset.vote = 'down';
        } else {
            section.classList.add('bg-[#2a3236]');
            upvoteSvg.setAttribute('fill', '#abc1ca');
            downvoteSvg.setAttribute('fill', '#abc1ca');
            section.dataset.vote = '';
        }
    })
    .catch(error => console.error('Initial state fetch error:', error));
});

function toggleEditForm(commentId) {
    const contentEl = document.querySelector(`.comment-content-${commentId}`);
    const formEl = document.querySelector(`.edit-form-${commentId}`);
    
    if (contentEl.style.display !== 'none') {
        contentEl.style.display = 'none';
        formEl.style.display = 'block';
    } else {
        contentEl.style.display = 'block';
        formEl.style.display = 'none';
    }
}
</script>