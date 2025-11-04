# Lebreach James Writeup

This site seems to be a LeBron James appreciation forum. This is my magnum opus, since I am from Cleveland after all.

We can create a user and log into the site:

<img width="757" height="597" alt="image" src="https://github.com/user-attachments/assets/d31bb735-5489-4b7a-9929-a190cc8b8a81" />

In the "View Posts" screen, we can see that some posts include images. Using Inspect Element (`Ctrl+Shift+I`) on most browsers, we can see the image's path.

<img width="842" height="742" alt="image" src="https://github.com/user-attachments/assets/006c88de-9a8b-4e4f-bb5c-0ac9ed230a34" />

Let's check if there is anything else interesting in that `assets` folder! We look and see that the webserver was not properly configured and is serving the `posts.db` and `users.db` files.

<img width="597" height="525" alt="image" src="https://github.com/user-attachments/assets/91e75f8c-d64e-4318-8ca3-1b05eaedd123" />

Downloading the `users.db` file we can see that it stores usernames, password hashes, and a `user_role`. It seems like the moderator accounts, such as `LeMod`, have a `user_role = 1`, which maybe elevated privileges.

<img width="526" height="440" alt="image" src="https://github.com/user-attachments/assets/d7cfd2ed-41c8-461c-97a1-c4983703e172" />

Let's return to the Registration / Login menus to see if we can somehow elevate our account.

On the login page we see the note reading: `*Moderators, check your dashboard for information about the recent breach.`.

<img width="570" height="600" alt="image" src="https://github.com/user-attachments/assets/c3724f0d-8070-4149-9a33-6973f1b68cb8" />

After some poking around, we find that on the registration page, there is a hidden attribute in the post request for account creation labeled `user_role` that is set to `0`.

<img width="776" height="684" alt="image" src="https://github.com/user-attachments/assets/6844b219-b83b-4029-a237-f2c8c05f4e9a" />

Of course we know that `user_role = 1` likely indicates an admin account, so we create a new account after manually editing the value.

<img width="736" height="659" alt="image" src="https://github.com/user-attachments/assets/fcb101a9-fa5a-4b43-8bc8-62a4bc64d690" />

Upon logging in to our new user, it seems to have worked as we are now a moderator:

<img width="744" height="252" alt="image" src="https://github.com/user-attachments/assets/48791705-e0ea-45a7-8eea-3102d04abf73" />

In the moderator dashboard, we are shown a message that the website was recently breached. The usernames and passwords of many users are also shown (which match up with the `users.db` usernames). However, one account that is not breached is `Lebron`, and the warning seems to imply he has the flags.

<img width="941" height="480" alt="image" src="https://github.com/user-attachments/assets/5d362f8f-9942-4189-8e59-3a3d8b5df396" />

From `users.db`, we have the hashes of all user passwords (including `Lebron`'s), and now we have the matching list of passwords for many of those accounts. The warning states that `Since the breach we stopped automatically assigning passwords`, meaning that `Lebron`'s password was likely generated a similar way to the leaked passwords.

With just the hashes in `users.db`, it would've been nearly impossible to crack the password for `Lebron`, but now we can generate a custom wordlist based on the leaked passwords.
The password policy looks to be an NBA team in all caps or lowercase with leetspeak (substituting letters for numbers) with a number on the end.
We wrote a Python script to generate this custom wordlist: [custom_wordlist.py](https://github.com/BaileyDalton007/micro_web_ctf/blob/main/writeups/lebreach_james_writeup/custom_wordlist.py)

<img width="576" height="180" alt="image" src="https://github.com/user-attachments/assets/7a9c67d5-49a9-4502-a9b1-2564daa51e3d" />

We see there are 337218 passwords in our wordlist to test against the `Lebron` hash. First, we need to know what kind of hashing algorithm was used for these passwords. Using `hash-identifier`, we see it is most likely `SHA-256`. Note: online tools like [hashes.com](https://hashes.com/en/tools/hash_identifier) work well too.

<img width="624" height="524" alt="image" src="https://github.com/user-attachments/assets/a84821eb-9d7d-42ed-9e70-610a055baafa" />

Now we can use `hashcat` to run our dictionary attack on the `Lebron` password. The `-m 1400` indicates `SHA-256` and `-a 0` tells hashcat not to mutate the passwords since we handled that in our Python script.

<img width="790" height="115" alt="image" src="https://github.com/user-attachments/assets/f9ec21e7-dbe9-4159-aa99-5e298d2810ca" />

We see that the password was successfully cracked!

<img width="653" height="444" alt="image" src="https://github.com/user-attachments/assets/6bdda837-323f-4c22-b25e-10cc254323b6" />

With the line:
```
bbfb6ebde0b6cc1fde8ec3a66740a5f7175d1b522c5b7763bc75e392fbc2b084:THUND3R05
```

Finally, we go to log in as `Lebron` with the password `THUND3R05`, and it works, giving us the flag!

<img width="433" height="291" alt="image" src="https://github.com/user-attachments/assets/19634077-6cda-4a59-9659-059ee96c839b" />

