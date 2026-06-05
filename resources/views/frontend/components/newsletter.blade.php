<div class="container-fluid cfe">
    <div class="newsletter-section">
        <div class="newsletter-container">

            <div class="newsletter-content">
                <h2 class="newsletter-title">
                    Sign up to our free newsletter!
                </h2>

                <p class="newsletter-text">
                    Get instant access to popular businesses, franchises,
                    industry advice and special offers.
                </p>
            </div>

            <form class="newsletter-form" x-data="newsletterForm()" @submit.prevent="submitForm">
                @csrf

                {{-- Email --}}
                <div  x-show="!message" class="form-group fo-grou">
                    <input type="email" name="email" x-model="form.email" class="form-input fo-input"
                        placeholder=" " @input="errors.email=''">
                    <label class="form-label">Email*</label>

                    <small x-show="errors.email" x-text="errors.email" class="block mt-1 text-red-500 text-sm"></small>
                </div>

                {{-- Country --}}
                <div  x-show="!message" class="form-group fo-grou">
                    <select name="country" x-model="form.country" class="form-input custom-select fo-input"
                        @change="errors.country=''">
                        <option value="" hidden></option>
                        <option value="IN">India</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="AU">Australia</option>
                        <option value="UK">United Kingdom</option>
                    </select>

                    <label class="form-label">
                        Country*
                    </label>

                    <span class="select-arrow">▼</span>

                    <small x-show="errors.country" x-text="errors.country"
                        class="block mt-1 text-red-500 text-sm"></small>
                </div>

                {{-- Submit --}}
                <button  x-show="!message" type="submit" class="subscribe-btn" :disabled="loading"
                    :class="loading ? 'opacity-70 cursor-not-allowed' : ''">
                    <span x-show="!loading">
                        Subscribe
                    </span>

                    <span x-show="loading">
                        Subscribing...
                    </span>
                </button>

                <div x-show="message" x-transition class="newsletter-message"
                    :class="success ? 'success-msg' : 'error-msg'">
                    <span x-show="success">✓</span>
                    <span x-show="!success">⚠</span>

                    <span x-html="message"></span>
                </div>

            </form>

        </div>
    </div>
    <style>
        .newsletter-form {
            position: relative;
        }

        .newsletter-message {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 37em;
            padding: 1em 1.2em;
            border-radius: .4em;
            font-weight: 600;
            text-align: center;
            z-index: 20;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5em;
            animation: fadeSlide .35s ease;
        }

        .success-msg {
            background: #00b258;
            color: #fff;
        }

        .error-msg {
            background: #e53935;
            color: #fff;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translate(-50%, 10px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }
    </style>
    <script>
        function newsletterForm() {
            return {

                loading: false,
                success: false,
                message: '',

                form: {
                    email: '',
                    country: ''
                },

                errors: {
                    email: '',
                    country: ''
                },

                submitForm() {

                    this.loading = true;
                    this.message = '';
                    this.success = false;
                    this.errors = {};

                    fetch("{{ route('newsletter.subscribe') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.form)
                        })
                        .then(async response => {

                            const data = await response.json();

                            this.loading = false;

                            if (!response.ok) {

                                if (data.errors) {
                                    this.errors = {
                                        email: data.errors.email?.[0] || '',
                                        country: data.errors.country?.[0] || ''
                                    };
                                }

                                return;
                            }

                            this.success = true;

                            this.message =
                                data.message ||
                                "Thanks for signing up! We've sent you an email to confirm your address. Check your inbox.";

                            this.form.email = '';
                            this.form.country = '';
                        })
                        .catch(() => {

                            this.loading = false;
                            this.success = false;

                            this.message =
                                'Something went wrong. Please try again.';
                        });
                }
            }
        }
    </script>
