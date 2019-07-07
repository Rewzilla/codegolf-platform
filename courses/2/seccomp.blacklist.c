#include <asm/unistd.h>
/*
This uses a blacklist approch.  This is NOT the most secure
way to do it, but is easier than figuring out all the syscalls
that the program actually needs :P  Also, I'd rather leave
creative options open for those golfers that may want/need to
use them.  Filters will be added on an as-needed basis.
*/

#include <seccomp.h>
#include <linux/seccomp.h>

void __attribute__((constructor(0))) init() {

	scmp_filter_ctx ctx;

	ctx = seccomp_init(SCMP_ACT_ALLOW);

	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(open), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(openat), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(creat), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(mkdir), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(rmdir), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(mkdirat), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(fork), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(vfork), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(execve), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(chdir), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(mknod), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(chmod), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(ptrace), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(mount), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(link), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(unlink), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(unlinkat), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(kill), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(tkill), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(tgkill), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(socketcall), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(clone), 0);

	seccomp_load(ctx);

}
