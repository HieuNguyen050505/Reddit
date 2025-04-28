// Voting functionality module
const VotingSystem = {
    init() {
        this.setupVoteForms();
        this.loadInitialVoteStates();
    },

    setupVoteForms() {
        document.querySelectorAll('.vote-form').forEach(form => {
            form.addEventListener('submit', this.handleVoteSubmit);
        });
    },

    handleVoteSubmit(event) {
        event.preventDefault();
        event.stopPropagation();

        const form = this;
        const postId = form.dataset.postId;
        const voteType = form.dataset.voteType;
        const voteSection = form.closest('.vote-section');
        const voteCountElement = voteSection.querySelector(`.vote-count-${postId}`);
        const upvoteSvg = voteSection.querySelector('.upvote-svg');
        const downvoteSvg = voteSection.querySelector('.downvote-svg');
        const isSelected = voteSection.dataset.vote === voteType;
        const formData = new FormData(form);

        if (isSelected) {
            formData.append('remove_vote', 'true');
        }

        fetch(form.action, {
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
                VotingSystem.updateVoteUI(voteSection, voteType, isSelected, upvoteSvg, downvoteSvg);
            } else {
                console.error('Vote failed:', data.error);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    },

    updateVoteUI(voteSection, voteType, isSelected, upvoteSvg, downvoteSvg) {
        if (isSelected) {
            // Reset to neutral state
            voteSection.classList.remove('bg-orange-600', 'bg-purple-600');
            voteSection.classList.add('bg-[#2a3236]');
            upvoteSvg.setAttribute('fill', '#abc1ca');
            downvoteSvg.setAttribute('fill', '#abc1ca');
            voteSection.dataset.vote = '';
        } else {
            // Set to selected state
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
    },

    loadInitialVoteStates() {
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
    }
};

// Comment editing functionality
const CommentEditor = {
    toggleEditForm(commentId) {
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
};

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize voting system
    VotingSystem.init();
    
    // Make comment editor function globally available
    window.toggleEditForm = CommentEditor.toggleEditForm;
});